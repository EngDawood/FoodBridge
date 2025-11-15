<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\FoodRequest;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    protected MatchingService $matchingService;

    public function __construct(MatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    public function index()
    {
        $userId = Auth::id();

        // Get paginated donations list
        $donations = Donation::where('donor_id', $userId)
            ->latest()
            ->paginate(10);

        // Calculate statistics for dashboard cards
        $totalDonations = Donation::where('donor_id', $userId)->count();
        $activeDonations = Donation::where('donor_id', $userId)
            ->whereIn('status', ['pending', 'scheduled'])
            ->count();
        $completedDonations = Donation::where('donor_id', $userId)
            ->where('status', 'delivered')
            ->count();

        // Calculate average rating from feedback received as donor
        $averageRating = \App\Models\Feedback::where('to_user_id', $userId)
            ->avg('rating') ?? 0;

        // Get recent activity - donations needing attention
        $pendingDonations = Donation::where('donor_id', $userId)
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('donor.index', compact(
            'donations',
            'totalDonations',
            'activeDonations',
            'completedDonations',
            'averageRating',
            'pendingDonations'
        ));
    }

    public function create()
    {
        return view('donor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000'],
            'expiration_date' => ['nullable', 'date', 'after_or_equal:today'],
            'pickup_time' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $donation = Donation::create([
            'donor_id' => Auth::id(),
            'food_type' => $validated['food_type'],
            'quantity' => $validated['quantity'],
            'expiration_date' => $validated['expiration_date'] ?? null,
            'pickup_time' => $validated['pickup_time'] ?? null,
            'status' => 'pending',
        ]);

        // Try to find a match automatically
        $match = $this->matchingService->matchDonation($donation);

        $message = $match
            ? 'Donation added and matched with a beneficiary request'
            : 'Donation added successfully';

        return redirect()->route('donations.index')->with('status', $message);
    }

    public function edit(Donation $donation)
    {
        $this->authorizeOwnership($donation);
        return view('donor.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $this->authorizeOwnership($donation);

        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000'],
            'expiration_date' => ['nullable', 'date', 'after_or_equal:today'],
            'pickup_time' => ['nullable', 'date', 'after_or_equal:today'],
            'status' => ['nullable', 'in:pending,scheduled,delivered'],
        ]);

        $donation->update($validated);

        return redirect()->route('donations.index')->with('status', 'Donation updated');
    }

    public function destroy(Donation $donation)
    {
        $this->authorizeOwnership($donation);
        $donation->delete();
        return redirect()->route('donations.index')->with('status', 'Donation deleted');
    }

    public function showMatches(Donation $donation)
    {
        $this->authorizeOwnership($donation);
        
        $matches = $this->matchingService->findMatchingRequests($donation, 20);
        
        return view('donor.matches', compact('donation', 'matches'));
    }

    private function authorizeOwnership(Donation $donation): void
    {
        abort_unless($donation->donor_id === Auth::id(), 403);
    }

    public function matchWithRequest(Donation $donation, FoodRequest $requestModel)
    {
        $this->authorizeOwnership($donation);
        // Ensure request belongs to a beneficiary (no need to be same user) and is pending
        abort_unless($requestModel->status === 'pending', 422);

        $this->matchingService->manualMatch($donation, $requestModel);

        return redirect()->route('donations.matches', $donation)
            ->with('status', 'Donation matched with the selected request');
    }
}


