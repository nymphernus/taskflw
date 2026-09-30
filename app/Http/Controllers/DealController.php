<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function index(Request $request): View
    {
        $query = Deal::query()->with('client');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->filled('amount_from')) {
            $query->where('amount', '>=', $request->input('amount_from'));
        }

        if ($request->filled('amount_to')) {
            $query->where('amount', '<=', $request->input('amount_to'));
        }

        $deals = $query->latest('created_at')->paginate(20);
        $clients = Client::orderBy('name')->get();

        return view('deals.index', compact('deals', 'clients'));
    }

    public function create(Request $request): View
    {
        $clients = Client::orderBy('name')->get();
        $selectedClient = $request->input('client_id');

        return view('deals.create', compact('clients', 'selectedClient'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title'     => 'required|string|max:255',
            'amount'    => 'required|numeric|min:0',
            'status'    => 'required|in:lead,in_progress,paid,rejected',
            'notes'     => 'nullable|string',
        ]);

        $deal = Deal::create($data);

        return redirect()->route('deals.index')
            ->with('success', 'Сделка создана');
    }

    public function edit(Deal $deal): View
    {
        $clients = Client::orderBy('name')->get();

        return view('deals.edit', compact('deal', 'clients'));
    }

    public function update(Request $request, Deal $deal): RedirectResponse
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title'     => 'required|string|max:255',
            'amount'    => 'required|numeric|min:0',
            'status'    => 'required|in:lead,in_progress,paid,rejected',
            'notes'     => 'nullable|string',
        ]);

        $deal->update($data);

        return redirect()->route('deals.index')
            ->with('success', 'Сделка обновлена');
    }

    public function destroy(Deal $deal): RedirectResponse
    {
        $deal->delete();

        return redirect()->route('deals.index')
            ->with('success', 'Сделка удалена');
    }

    public function updateStatus(Request $request, Deal $deal): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:lead,in_progress,paid,rejected',
        ]);

        $deal->update(['status' => $data['status']]);

        return redirect()->route('deals.index')
            ->with('success', 'Статус сделки обновлён');
    }
}
