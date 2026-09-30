<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Interaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function store(Request $request, Client $client): RedirectResponse
    {
        $data = $request->validate([
            'type'        => 'required|in:call,email,meeting,other',
            'description' => 'required|string',
            'happened_at' => 'required|date',
        ]);

        $client->interactions()->create($data);

        return redirect()->route('clients.show', $client)
            ->with('success', 'Взаимодействие добавлено');
    }

    public function destroy(Interaction $interaction): RedirectResponse
    {
        $clientId = $interaction->client_id;
        $interaction->delete();

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Взаимодействие удалено');
    }
}
