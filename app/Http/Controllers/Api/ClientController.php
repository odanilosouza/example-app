<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends ApiController
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->user()->hasRole('Cliente')) {
            $query->where('id', $request->user()->client_id);
        }

        $clients = $query->paginate(20);

        return $this->success(['clients' => $clients]);
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);

        return $this->success(['client' => $client]);
    }

    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $client->fill($request->only([
            'razao_social',
            'nome_fantasia',
            'email',
            'telefone',
            'endereco',
            'cidade',
            'estado',
            'cep',
            'observations',
        ]));

        if ($request->hasFile('logo')) {
            $client->logo_path = $request->file('logo')->store('clientes/'.$client->id.'/logo', 'public');
        }

        $client->save();

        return $this->success(['client' => $client], 'Cliente atualizado com sucesso.');
    }

    public function history(Client $client)
    {
        $this->authorize('view', $client);

        return $this->success([ 
            'documents' => $client->documents()->latest()->get(),
            'reports' => $client->reports()->latest()->get(),
            'images' => $client->images()->latest()->get(),
            'visit_reports' => $client->visitReports()->latest()->get(),
        ]);
    }
}
