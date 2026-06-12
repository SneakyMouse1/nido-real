<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class PublicAgencyController extends Controller
{
    /**
     * Display a listing of the agencies.
     */
    public function index(Request $request)
    {
        $agencies = Agency::active()
            ->withCount(['properties' => function ($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->paginate(12);

        return view('public.agencies.index', compact('agencies'));
    }

    /**
     * Display the specified agency and its agents.
     */
    public function show($slug)
    {
        $agency = Agency::active()
            ->with(['users' => function ($query) {
                $query->active();
            }])
            ->withCount(['properties' => function ($query) {
                $query->published();
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        // Latest 6 published properties of this agency for the showcase section
        $latestProperties = $agency->properties()
            ->published()
            ->with(['propertyType'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('public.agencies.show', compact('agency', 'latestProperties'));
    }
}
