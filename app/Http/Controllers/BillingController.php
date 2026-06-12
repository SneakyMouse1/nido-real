<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\AgencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function __construct(private readonly AgencyService $agencyService) {}

    /**
     * Show the billing plans page.
     * Retrieve the current agency of the logged-in manager via the user-agency relationship.
     */
    public function index()
    {
        $user   = Auth::user();

        // Allow manager, admin, superadmin. Block agent.
        if (!$user->hasAnyRole(['agency_manager', 'superadmin', 'admin'])) {
            abort(403, 'Acceso denegado. Solo managers o admins.');
        }

        $agency = $user->agencies()->first();
        if (!$agency && $user->hasAnyRole(['superadmin', 'admin'])) {
            $agency = \App\Models\Agency::first();
        }

        if (!$agency) {
            abort(403, 'No agency associated with this user.');
        }

        $plans         = Plan::active()->ordered()->get();
        $currentPlan   = $agency->plan;

        return view('billing.plans', compact('plans', 'agency', 'currentPlan'));
    }

    /**
     * Simulate a payment — update the agency plan and redirect to the cabinet dashboard.
     * No real payment processing; this is a mock for educational purposes.
     */
    public function simulatePayment(Request $request)
    {
        $request->validate(['plan_id' => ['required', 'exists:plans,id']]);

        $user   = Auth::user();

        if (!$user->hasAnyRole(['agency_manager', 'superadmin', 'admin'])) {
            abort(403);
        }

        $agency = $user->agencies()->first();
        if (!$agency && $user->hasAnyRole(['superadmin', 'admin'])) {
            $agency = \App\Models\Agency::first();
        }

        if (!$agency) {
            abort(403);
        }

        $plan = Plan::findOrFail($request->plan_id);
        $this->agencyService->changePlan($agency, $plan);

        // Redirect to the success page with plan_id in session
        return redirect()
            ->route('billing.success')
            ->with(['success_plan_id' => $plan->id, 'agency_id' => $agency->id]);
    }

    /**
     * Show the payment success page.
     */
    public function paymentSuccess()
    {
        $planId   = session('success_plan_id');
        $agencyId = session('agency_id');

        if (!$planId || !$agencyId) {
            return redirect()->route('billing.plans');
        }

        $plan   = Plan::findOrFail($planId);
        $agency = \App\Models\Agency::findOrFail($agencyId);
        $user   = Auth::user();

        // Security check
        if (!$user->hasAnyRole(['superadmin', 'admin']) && !$user->agencies->contains($agency)) {
            abort(403);
        }

        return view('billing.success', compact('plan', 'agency'));
    }
}
