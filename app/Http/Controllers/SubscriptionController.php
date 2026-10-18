<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('schools.index');
        }

        $school = $user->school;
        abort_unless($school, 403, 'Akaun anda belum dikaitkan dengan mana-mana sekolah.');

        $usage = [
            'classes'  => $school->classCount(),
            'students' => Student::where('school_id', $school->id)->whereNotIn('status', ['Berhenti', 'Pindah'])->count(),
        ];

        $plans     = config('plans.plans');
        $modules   = config('plans.modules');
        $typePlans = config("plans.types.{$school->type}.plans", array_keys($plans));
        $highlight = $request->query('modul');

        $payments      = \App\Models\Payment::where('school_id', $school->id)->latest()->paginate(10);
        $billingReady  = app(\App\Services\Bayarcash::class)->isConfigured();

        return view('subscription.index', compact('school', 'usage', 'plans', 'modules', 'typePlans', 'highlight', 'payments', 'billingReady'));
    }
}
