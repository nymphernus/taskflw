<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Deal;
use App\Models\Interaction;
use App\Models\Task;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $clientsCount = Client::count();

        $activeDeals = Deal::whereIn('status', ['lead', 'in_progress']);
        $activeDealsCount = (clone $activeDeals)->count();
        $activeDealsSum = (clone $activeDeals)->sum('amount');

        $expectedRevenue = Deal::where('status', 'in_progress')->sum('amount');
        $paidTotal = Deal::where('status', 'paid')->sum('amount');

        $upcomingTasks = Task::where('status', 'open')
            ->whereNotNull('due_date')
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        $recentInteractions = Interaction::with('client')
            ->latest('happened_at')
            ->limit(5)
            ->get();

        $dealsByStatus = [];
        foreach (Deal::STATUSES as $status => $label) {
            $query = Deal::where('status', $status);
            $dealsByStatus[$status] = [
                'label' => $label,
                'count' => (clone $query)->count(),
                'sum'   => (clone $query)->sum('amount'),
            ];
        }

        return view('dashboard', compact(
            'clientsCount',
            'activeDealsCount',
            'activeDealsSum',
            'expectedRevenue',
            'paidTotal',
            'upcomingTasks',
            'recentInteractions',
            'dealsByStatus',
        ));
    }
}
