<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\FoodRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Show tasks assigned to the volunteer that are not started yet (available to start).
     */
    public function available()
    {
        $availableTasks = DeliveryTask::with(['donation.donor', 'donation.request.beneficiary'])
            ->whereNull('volunteer_id')
            ->where('status', 'assigned')
            ->orderByDesc('id')
            ->get();

        // Calculate priority based on urgency (pickup time and expiration date)
        $availableTasks->each(function ($task) {
            $task->priority = $this->calculatePriority($task);
            $task->urgencyLabel = $this->getUrgencyLabel($task->priority);
            $task->urgencyColor = $this->getUrgencyColor($task->priority);
        });

        // Sort by priority (highest first)
        $availableTasks = $availableTasks->sortByDesc('priority');

        // Calculate dashboard statistics
        $totalAvailable = $availableTasks->count();
        $highPriority = $availableTasks->where('priority', '>=', 7)->count();
        $mediumPriority = $availableTasks->whereBetween('priority', [4, 6])->count();
        $lowPriority = $availableTasks->where('priority', '<', 4)->count();

        return view('volunteer.available', [
            'availableTasks' => $availableTasks,
            'totalAvailable' => $totalAvailable,
            'highPriority' => $highPriority,
            'mediumPriority' => $mediumPriority,
            'lowPriority' => $lowPriority,
        ]);
    }

    /**
     * Show all tasks for the volunteer grouped by status.
     */
    public function myTasks()
    {
        $tasks = DeliveryTask::with(['donation.donor', 'donation.request.beneficiary'])
            ->where('volunteer_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        // Calculate priority for each task
        $tasks->each(function ($task) {
            $task->priority = $this->calculatePriority($task);
            $task->urgencyLabel = $this->getUrgencyLabel($task->priority);
            $task->urgencyColor = $this->getUrgencyColor($task->priority);
        });

        $grouped = [
            'assigned' => $tasks->where('status', 'assigned')->sortByDesc('priority'),
            'in_progress' => $tasks->where('status', 'in_progress')->sortByDesc('priority'),
            'completed' => $tasks->where('status', 'completed'),
        ];

        // Calculate statistics
        $totalTasks = $tasks->count();
        $completedCount = $grouped['completed']->count();
        $inProgressCount = $grouped['in_progress']->count();
        $assignedCount = $grouped['assigned']->count();

        return view('volunteer.my-tasks', [
            'tasks' => $tasks,
            'grouped' => $grouped,
            'totalTasks' => $totalTasks,
            'completedCount' => $completedCount,
            'inProgressCount' => $inProgressCount,
            'assignedCount' => $assignedCount,
        ]);
    }

    /**
     * Start a task: assigned -> in_progress
     */
    public function start(DeliveryTask $task)
    {
        // Verify ownership
        if ($task->volunteer_id !== Auth::id() || $task->status !== 'assigned') {
            abort(403);
        }

        $oldStatus = $task->status;
        $task->update(['status' => 'in_progress']);

        // Notify relevant parties
        $this->notificationService->notifyDeliveryStatusChange($task, $oldStatus);

        return back()->with('status', 'Delivery task started');
    }

    /**
     * Complete a task: in_progress -> completed
     */
    public function complete(DeliveryTask $task)
    {
        // Verify ownership
        if ($task->volunteer_id !== Auth::id() || $task->status !== 'in_progress') {
            abort(403);
        }

        $oldStatus = $task->status;
        $task->update(['status' => 'completed']);

        // Update donation status to delivered
        $donation = $task->donation;
        if ($donation) {
            $donation->update(['status' => 'delivered']);

            // Update associated request to fulfilled
            $request = FoodRequest::where('donation_id', $donation->id)->first();
            if ($request) {
                $request->update(['status' => 'fulfilled']);
            }
        }

        // Notify relevant parties
        $this->notificationService->notifyDeliveryStatusChange($task, $oldStatus);

        return back()->with('status', 'Delivery task completed successfully');
    }

    /**
     * Claim an unassigned task
     */
    public function claim(DeliveryTask $task)
    {
        if (!is_null($task->volunteer_id) || $task->status !== 'assigned') {
            abort(403);
        }

        $task->update(['volunteer_id' => Auth::id()]);

        // Optional: notify stakeholders about assignment change
        $this->notificationService->notifyDeliveryStatusChange($task, 'assigned');

        return back()->with('status', 'Task claimed successfully');
    }

    /**
     * Calculate task priority based on urgency factors
     * Returns a score from 1-10 (10 being most urgent)
     */
    private function calculatePriority(DeliveryTask $task): int
    {
        $priority = 5; // Default medium priority

        if ($task->donation) {
            // High priority if pickup time is within 24 hours
            if ($task->donation->pickup_time) {
                $hoursUntilPickup = now()->diffInHours($task->donation->pickup_time, false);
                if ($hoursUntilPickup < 0) {
                    $priority = 10; // Overdue
                } elseif ($hoursUntilPickup <= 6) {
                    $priority = 9;
                } elseif ($hoursUntilPickup <= 24) {
                    $priority = 7;
                } elseif ($hoursUntilPickup <= 48) {
                    $priority = 5;
                }
            }

            // Increase priority if expiration date is soon
            if ($task->donation->expiration_date) {
                $hoursUntilExpiration = now()->diffInHours($task->donation->expiration_date, false);
                if ($hoursUntilExpiration < 0) {
                    $priority = max($priority, 10); // Expired
                } elseif ($hoursUntilExpiration <= 12) {
                    $priority = max($priority, 8);
                } elseif ($hoursUntilExpiration <= 24) {
                    $priority = max($priority, 6);
                }
            }
        }

        return min(10, max(1, $priority));
    }

    /**
     * Get urgency label based on priority score
     */
    private function getUrgencyLabel(int $priority): string
    {
        if ($priority >= 8) return 'Urgent';
        if ($priority >= 5) return 'Medium';
        return 'Low';
    }

    /**
     * Get urgency color class based on priority score
     */
    private function getUrgencyColor(int $priority): string
    {
        if ($priority >= 8) return 'red';
        if ($priority >= 5) return 'yellow';
        return 'green';
    }
}


