<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Notifications\Notification;

class ContactController extends ApiController
{
    public function send(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        return $this->success(['contact' => $contact], 'Mensagem enviada com sucesso.', 201);
    }
}
