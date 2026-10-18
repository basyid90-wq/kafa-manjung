<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Route guard for plan-gated modules: ->middleware('plan:rph')
 * Locked modules redirect to the subscription page (upsell) instead of a bare 403.
 */
class EnsurePlanAllows
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        if ($user && $user->canUse($module)) {
            return $next($request);
        }

        $label = config("plans.modules.{$module}.label", 'Modul ini');
        $plan  = config('plans.plans.' . config("plans.modules.{$module}.plan", 'sekolah') . '.label');

        if ($user && $user->hasRole('Ibu Bapa') && !$user->hasAnyRole(['Guru Besar', 'Guru KAFA'])) {
            $message = 'Portal Ibu Bapa belum diaktifkan oleh sekolah anak anda.';
        } elseif ($user && !$user->school_id) {
            $message = 'Akaun anda belum dikaitkan dengan mana-mana sekolah.';
        } else {
            $message = "{$label} hanya tersedia dalam pakej {$plan}. Naik taraf untuk membuka modul ini.";
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 403);
        }

        if ($user && $user->school_id && !$user->hasRole('Ibu Bapa')) {
            return redirect()->route('subscription.index', ['modul' => $module])->with('error', $message);
        }

        return redirect()->route('dashboard')->with('error', $message);
    }
}
