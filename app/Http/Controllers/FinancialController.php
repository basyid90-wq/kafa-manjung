<?php

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use App\Models\AccountCategory;
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

        $records = FinancialRecord::where('school_id', $user->school_id)
            ->with(['category', 'user'])
            ->latest('transaction_date')
            ->paginate(10);

        $balance = $this->financialService->calculateBalance($user->school_id);

        return view('financial.index', compact('records', 'balance'));
    }

    public function create()
    {
        $categories = AccountCategory::all();
        return view('financial.create', compact('categories'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->school_id, 403, 'Akaun anda belum dikaitkan dengan mana-mana sekolah.');

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
        $this->authorizeSchool($record->school_id);

        return $this->financialService->exportToPdfTemplate($record);
    }
}
