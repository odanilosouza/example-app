<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends ApiController
{
    public function index(Request $request)
    {
        $query = Document::with('client');

        if ($request->user()->hasRole('Cliente')) {
            $query->where('client_id', $request->user()->client_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('year')) {
            $query->where('reference_year', $request->year);
        }

        $documents = $query->paginate(20);

        return $this->success(['documents' => $documents]);
    }

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();

        $document = Document::create([
            'client_id' => $data['client_id'],
            'uploaded_by' => $request->user()->id,
            'name' => $data['name'],
            'category' => $data['category'],
            'description' => $data['description'] ?? null,
            'reference_year' => $data['reference_year'] ?? null,
            'mime_type' => $request->file('file')->getClientMimeType(),
            'size' => $request->file('file')->getSize(),
        ]);

        $document->addMediaFromRequest('file')->toMediaCollection('documents');

        return $this->success(['document' => $document], 'Documento enviado com sucesso.', 201);
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);

        return $this->success(['document' => $document]);
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $this->authorize('update', $document);

        $document->fill($request->validated());

        if ($request->hasFile('file')) {
            $document->clearMediaCollection('documents');
            $document->addMediaFromRequest('file')->toMediaCollection('documents');
            $document->mime_type = $request->file('file')->getClientMimeType();
            $document->size = $request->file('file')->getSize();
        }

        $document->save();

        return $this->success(['document' => $document], 'Documento atualizado.');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        $document->delete();

        return $this->success([], 'Documento removido.');
    }

    public function download(Request $request, Document $document)
    {
        $this->authorize('view', $document);

        $media = $document->getFirstMedia('documents');

        if (! $media) {
            return $this->error('Arquivo não encontrado.', 404);
        }

        $request->user()->downloads()->create([
            'client_id' => $document->client_id,
            'subject_type' => Document::class,
            'subject_id' => $document->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Storage::disk($media->disk)->download($media->getPath(), $media->file_name);
    }
}
