<?php

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use App\Models\AccountCategory;
use App\Models\School;
use App\Services\FinancialService;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    protected $financialService;

    public function __construct(FinancialService $financialService)
    {
        $this->financialService = $financialService;
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Penyelia KAFA')) {
            $districtId = $user->district_id;
            $records = FinancialRecord::whereHas('school', function ($q) use ($districtId) {
                    $q->where('district_id', $districtId);
                })
                ->with(['category', 'user', 'school'])
                ->latest('transaction_date')
                ->paginate(15);

            $balance = FinancialRecord::whereHas('school', function ($q) use ($districtId) {
                    $q->where('district_id', $districtId);
                })
                ->selectRaw("SUM(CASE WHEN transaction_type = 'in' THEN amount ELSE -amount END) as total")
                ->value('total') ?? 0;
        } else {
            $records = FinancialRecord::where('school_id', $user->school_id)
                ->with(['category', 'user'])
                ->latest('transaction_date')
                ->paginate(15);

            $balance = $this->financialService->calculateBalance($user->school_id);
        }

        return view('financial.index', compact('records', 'balance'));
    }

    public function create()
    {
        $categories = AccountCategory::all();
        return view('financial.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'transaction_type' => 'required|in:in,out',
            'account_category_id' => 'required|exists:account_categories,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'reference_no' => 'nullable|string',
        ]);

        FinancialRecord::create([
            'school_id' => auth()->user()->school_id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'transaction_type' => $request->transaction_type,
            'account_category_id' => $request->account_category_id,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            'reference_no' => $request->reference_no,
            'status' => 'Verified', // Defaulting to Verified as per auto-approval logic for now
        ]);

        return redirect()->route('financial.index')->with('success', 'Rekod kewangan berjaya disimpan.');
    }

    public function export(FinancialRecord $record)
    {
        $user = auth()->user();

        if ($user->hasRole('Penyelia KAFA')) {
            $schoolInDistrict = School::where('id', $record->school_id)
                ->where('district_id', $user->district_id)
                ->exists();
            if (!$schoolInDistrict) abort(403);
        } elseif ($user->hasRole('Bendahari Sekolah') && $record->school_id !== $user->school_id) {
            abort(403);
        }

        return $this->financialService->exportToPdfTemplate($record);
    }
}
