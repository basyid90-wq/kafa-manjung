<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookOrder;
use App\Models\BookOrderItem;
use App\Models\School;
use App\Models\User;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Mpdf\Mpdf;

class BookOrderController extends Controller
{
    // ─── Troli (Cart) ────────────────────────────────────────────────────────

    public function cartAdd(Request $request)
    {
        $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session('book_cart', []);
        $qty  = (int) $request->quantity;

        if ($qty > 0) {
            $cart[$request->book_id] = $qty;
        } else {
            unset($cart[$request->book_id]);
        }

        session(['book_cart' => $cart]);

        return response()->json([
            'success'     => true,
            'total_items' => count($cart),
            'total_qty'   => array_sum($cart),
        ]);
    }

    public function cartView()
    {
        $cart  = session('book_cart', []);
        $books = Book::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $totalPrice = 0;
        foreach ($cart as $bookId => $qty) {
            if (isset($books[$bookId])) {
                $totalPrice += $books[$bookId]->price * $qty;
            }
        }

        return view('book_orders.cart', compact('cart', 'books', 'totalPrice'));
    }

    public function cartClear()
    {
        session()->forget('book_cart');
        return redirect()->route('book_orders.create')->with('success', 'Troli telah dikosongkan.');
    }

    // ─── CRUD ────────────────────────────────────────────────────────────────

    public function index()
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            $orders = BookOrder::with(['school', 'district'])->latest()->paginate(10);
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $orders = BookOrder::with(['school', 'district'])
                ->whereHas('school', fn($q) => $q->where('district_id', $user->district_id))
                ->latest()
                ->paginate(10);
        } else {
            $orders = BookOrder::with(['school', 'district'])
                ->where('school_id', $user->school_id)
                ->latest()
                ->paginate(10);
        }

        return view('book_orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $search = $request->query('search');
        $cart   = session('book_cart', []);

        $books = Book::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('tahun_darjah', 'like', "%{$search}%"))
            ->orderBy('tahun_darjah')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('book_orders.create', compact('books', 'search', 'cart'));
    }

    public function store(Request $request)
    {
        $cart = session('book_cart', []);

        if (empty($cart)) {
            return redirect()->route('book_orders.cart')
                ->with('error', 'Troli kosong. Sila tambah buku sebelum membuat tempahan.');
        }

        $user   = Auth::user();
        $school = $user->school;

        $order = BookOrder::create([
            'school_id'   => $user->school_id,
            'district_id' => $user->district_id ?? ($school?->district_id),
            'status'      => 'draft',
            'order_date'  => now(),
            'notes'       => $request->notes,
        ]);

        $totalPrice = 0;
        foreach ($cart as $bookId => $quantity) {
            $book = Book::find($bookId);
            if (!$book || $quantity <= 0) continue;

            BookOrderItem::create([
                'book_order_id'  => $order->id,
                'book_id'        => $book->id,
                'quantity'       => $quantity,
                'price_at_order' => $book->price,
            ]);

            $totalPrice += $book->price * $quantity;
        }

        $order->update(['total_price' => $totalPrice]);
        session()->forget('book_cart');

        return redirect()->route('book_orders.show', $order)
            ->with('success', 'Draf tempahan berjaya dicipta.');
    }

    public function show(BookOrder $bookOrder)
    {
        $user = Auth::user();

        if ($user->hasRole('Penyelia KAFA') && !$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $schoolInDistrict = School::where('id', $bookOrder->school_id)
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        } elseif (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA', 'Pembekal'])) {
            if ($bookOrder->school_id !== $user->school_id) abort(403);
        }

        $bookOrder->load(['items.book', 'school', 'district']);
        return view('book_orders.show', compact('bookOrder'));
    }

    public function edit(BookOrder $bookOrder)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            if ($bookOrder->school_id !== $user->school_id) abort(403);
        }

        if ($bookOrder->status !== 'draft') {
            return redirect()->route('book_orders.show', $bookOrder)
                ->with('error', 'Hanya draf boleh diedit.');
        }

        $books       = Book::orderBy('tahun_darjah')->orderBy('name')->get();
        $existingQty = $bookOrder->items->keyBy('book_id');

        return view('book_orders.edit', compact('bookOrder', 'books', 'existingQty'));
    }

    public function update(Request $request, BookOrder $bookOrder)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            if ($bookOrder->school_id !== $user->school_id) abort(403);
        }

        if ($bookOrder->status !== 'draft') {
            return redirect()->route('book_orders.show', $bookOrder)
                ->with('error', 'Hanya draf boleh diedit.');
        }

        $bookOrder->items()->delete();

        $totalPrice = 0;
        foreach ($request->input('items', []) as $bookId => $qty) {
            $qty  = (int) $qty;
            $book = Book::find($bookId);
            if (!$book || $qty <= 0) continue;

            BookOrderItem::create([
                'book_order_id'  => $bookOrder->id,
                'book_id'        => $book->id,
                'quantity'       => $qty,
                'price_at_order' => $book->price,
            ]);

            $totalPrice += $book->price * $qty;
        }

        $bookOrder->update([
            'total_price' => $totalPrice,
            'notes'       => $request->notes,
        ]);

        return redirect()->route('book_orders.show', $bookOrder)
            ->with('success', 'Draf tempahan berjaya dikemaskini.');
    }

    public function submit(BookOrder $bookOrder)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            if ($bookOrder->school_id !== $user->school_id) abort(403);
        }

        if ($bookOrder->status !== 'draft') {
            return back()->with('error', 'Hanya draf boleh dihantar.');
        }

        $bookOrder->update(['status' => 'submitted_by_school']);

        $admins = User::role(['Super Admin', 'Pentadbir'])->get();
        Notification::send($admins, new OrderStatusNotification($bookOrder, 'submitted_by_school'));

        return redirect()->route('book_orders.show', $bookOrder)
            ->with('success', 'Tempahan telah dihantar untuk semakan admin.');
    }

    public function approve(BookOrder $bookOrder)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            abort(403);
        }

        if ($user->hasRole('Penyelia KAFA') && !$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $schoolInDistrict = School::where('id', $bookOrder->school_id)
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        }

        if ($bookOrder->status !== 'submitted_by_school') {
            return back()->with('error', 'Hanya tempahan yang dihantar boleh diluluskan.');
        }

        $bookOrder->update(['status' => 'approved_by_admin']);

        $schoolUsers = User::role(['Super Admin', 'Pentadbir', 'Guru Besar'])
            ->where('school_id', $bookOrder->school_id)
            ->get();
        Notification::send($schoolUsers, new OrderStatusNotification($bookOrder, 'approved_by_admin'));

        return redirect()->route('book_orders.show', $bookOrder)
            ->with('success', 'Tempahan telah diluluskan.');
    }

    public function complete(BookOrder $bookOrder)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            abort(403);
        }

        if ($user->hasRole('Penyelia KAFA') && !$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $schoolInDistrict = School::where('id', $bookOrder->school_id)
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        }

        if ($bookOrder->status !== 'delivered_to_school') {
            return back()->with('error', 'Pesanan hanya boleh ditandakan sebagai selesai selepas ianya dihantar ke sekolah oleh pembekal.');
        }

        $bookOrder->update(['status' => 'completed']);

        return redirect()->route('book_orders.show', $bookOrder)
            ->with('success', 'Tempahan ditandakan sebagai selesai.');
    }

    // ─── Rumusan Pembekal ────────────────────────────────────────────────────

    public function supplierSummary(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            abort(403);
        }

        $month   = $request->query('month');
        $year    = $request->query('year');
        $summary = $this->buildSummaryQuery($user, $month, $year)->get();

        return view('book_orders.supplier_summary', compact('summary', 'month', 'year'));
    }

    public function supplierSummaryPdf(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            abort(403);
        }

        $month   = $request->query('month');
        $year    = $request->query('year');
        $summary = $this->buildSummaryQuery($user, $month, $year)->get();

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
        ];
        $filterLabel = ($month && $year)
            ? ($monthNames[(int) $month] . ' ' . $year)
            : (($year) ? $year : 'Semua Masa');

        $html    = view('book_orders.supplier_summary_pdf', compact('summary', 'filterLabel'))->render();
        $tempDir = storage_path('app/mpdf_temp');

        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $mpdf = new Mpdf([
            'mode'         => 'utf-8',
            'format'       => 'A4',
            'autoArabic'   => true,
            'default_font' => 'lateef',
            'tempDir'      => $tempDir,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'))
            ->header('Content-Type', 'application/pdf');
    }

    private function buildSummaryQuery($user, $month = null, $year = null)
    {
        return BookOrderItem::whereHas('order', function ($q) use ($user, $month, $year) {
            $q->whereIn('status', ['approved_by_admin', 'processing_by_supplier', 'delivered_to_school', 'completed']);

            if ($user->hasRole('Penyelia KAFA') && !$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
                $q->whereHas('school', fn($sq) => $sq->where('district_id', $user->district_id));
            }

            if ($month && $year) {
                $q->whereMonth('order_date', $month)->whereYear('order_date', $year);
            } elseif ($year) {
                $q->whereYear('order_date', $year);
            }
        })
        ->selectRaw('book_id, sum(quantity) as total_quantity')
        ->with('book')
        ->groupBy('book_id');
    }

    // ─── Pembekal Actions ────────────────────────────────────────────────────

    public function supplierIndex()
    {
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            abort(403);
        }

        $orders = BookOrder::with(['school', 'district'])
            ->whereIn('status', ['approved_by_admin', 'processing_by_supplier', 'delivered_to_school'])
            ->latest()
            ->get();

        return view('book_orders.supplier_index', compact('orders'));
    }

    public function process(BookOrder $bookOrder)
    {
        if (!Auth::user()->hasAnyRole(['Pembekal', 'Super Admin', 'Pentadbir'])) {
            abort(403);
        }

        if ($bookOrder->status !== 'approved_by_admin') {
            return back()->with('error', 'Hanya tempahan yang diluluskan boleh mula diproses.');
        }

        $bookOrder->update(['status' => 'processing_by_supplier']);

        $schoolUsers = User::role(['Super Admin', 'Pentadbir', 'Guru Besar'])
            ->where('school_id', $bookOrder->school_id)
            ->get();
        Notification::send($schoolUsers, new OrderStatusNotification($bookOrder, 'processing_by_supplier'));

        return redirect()->route('book_orders.supplier_index')
            ->with('success', 'Tempahan kini sedang diproses.');
    }

    public function deliver(BookOrder $bookOrder)
    {
        if (!Auth::user()->hasAnyRole(['Pembekal', 'Super Admin', 'Pentadbir'])) {
            abort(403);
        }

        if ($bookOrder->status !== 'processing_by_supplier') {
            return back()->with('error', 'Hanya tempahan yang sedang diproses boleh ditandakan sebagai dihantar.');
        }

        $bookOrder->update(['status' => 'delivered_to_school']);

        $schoolUsers = User::role(['Super Admin', 'Pentadbir', 'Guru Besar'])
            ->where('school_id', $bookOrder->school_id)
            ->get();
        Notification::send($schoolUsers, new OrderStatusNotification($bookOrder, 'delivered_to_school'));

        return redirect()->route('book_orders.supplier_index')
            ->with('success', 'Tempahan telah dihantar ke sekolah.');
    }

    public function destroy(BookOrder $bookOrder)
    {
        $user = Auth::user();

        if ($user->hasRole('Penyelia KAFA') && !$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $schoolInDistrict = School::where('id', $bookOrder->school_id)
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        } elseif (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            if ($bookOrder->school_id !== $user->school_id) abort(403);
            if ($bookOrder->status !== 'draft') {
                return back()->with('error', 'Hanya tempahan draf boleh dipadam.');
            }
        }

        $bookOrder->items()->delete();
        $bookOrder->delete();

        return redirect()->route('book_orders.index')
            ->with('success', 'Tempahan berjaya dipadam.');
    }
}
