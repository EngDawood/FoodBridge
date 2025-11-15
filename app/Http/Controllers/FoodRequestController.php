<?php

namespace App\Http\Controllers;

use App\Models\FoodRequest;
use App\Models\Donation;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodRequestController extends Controller
{
    protected MatchingService $matchingService;

    public function __construct(MatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    public function index()
    {
        $userId = Auth::id();

        // Get paginated requests list
        $requests = FoodRequest::where('beneficiary_id', $userId)
            ->latest()
            ->paginate(10);

        // Calculate statistics
        $totalRequests = FoodRequest::where('beneficiary_id', $userId)->count();
        $pendingRequests = FoodRequest::where('beneficiary_id', $userId)
            ->where('status', 'pending')
            ->count();
        $matchedRequests = FoodRequest::where('beneficiary_id', $userId)
            ->where('status', 'matched')
            ->count();
        $fulfilledRequests = FoodRequest::where('beneficiary_id', $userId)
            ->where('status', 'fulfilled')
            ->count();

        // Get requests with delivery tasks for upcoming pickups
        $upcomingPickups = FoodRequest::where('beneficiary_id', $userId)
            ->whereIn('status', ['matched', 'scheduled'])
            ->whereHas('donation', function($query) {
                $query->whereNotNull('pickup_time')
                    ->where('pickup_time', '>=', now());
            })
            ->with(['donation' => function($query) {
                $query->select('id', 'food_type', 'quantity', 'pickup_time', 'donor_id');
            }])
            ->latest()
            ->take(5)
            ->get();

        // Get match suggestions - find available donations that match beneficiary's needs
        $userRequests = FoodRequest::where('beneficiary_id', $userId)
            ->where('status', 'pending')
            ->get();

        $matchSuggestions = [];
        foreach ($userRequests as $request) {
            $matches = $this->matchingService->findMatchingDonations($request, 3);
            if ($matches->count() > 0) {
                $matchSuggestions[] = [
                    'request' => $request,
                    'matches' => $matches
                ];
            }
        }

        return view('beneficiary.index', compact(
            'requests',
            'totalRequests',
            'pendingRequests',
            'matchedRequests',
            'fulfilledRequests',
            'upcomingPickups',
            'matchSuggestions'
        ));
    }

    public function create()
    {
        return view('beneficiary.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $foodRequest = FoodRequest::create([
            'beneficiary_id' => Auth::id(),
            'food_type' => $validated['food_type'],
            'quantity' => $validated['quantity'],
            'note' => $validated['note'] ?? null,
            'status' => 'pending',
        ]);

        // Try to find a matching donation
        $match = $this->matchingService->matchRequest($foodRequest);

        $message = $match
            ? 'Request created and matched with an available donation'
            : 'Request created successfully';

        return redirect()->route('requests.index')->with('status', $message);
    }

    public function edit(FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);
        return view('beneficiary.edit', ['request' => $requestModel]);
    }

    public function update(Request $request, FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);

        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000'],
            'note' => ['nullable', 'string', 'max:500'],
            'status' => ['nullable', 'in:pending,matched,fulfilled'],
        ]);

        $requestModel->update($validated);

        return redirect()->route('requests.index')->with('status', 'Request updated');
    }

    public function destroy(FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);
        $requestModel->delete();
        return redirect()->route('requests.index')->with('status', 'Request deleted');
    }

    public function showMatches(FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);
        
        $matches = $this->matchingService->findMatchingDonations($requestModel, 20);
        
        return view('beneficiary.matches', ['request' => $requestModel, 'matches' => $matches]);
    }

    private function authorizeOwnership(FoodRequest $request): void
    {
        abort_unless($request->beneficiary_id === Auth::id(), 403);
    }

    public function matchWithDonation(FoodRequest $requestModel, Donation $donation)
    {
        $this->authorizeOwnership($requestModel);
        abort_unless($requestModel->status === 'pending', 422);

        $this->matchingService->manualMatch($donation, $requestModel);

        return redirect()->route('requests.matches', $requestModel)
            ->with('status', 'Request matched with the selected donation');
    }
}


