<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Image\StoreImageRequest;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends ApiController
{
    public function index(Request $request)
    {
        $query = Image::with('client');

        if ($request->user()->hasRole('Cliente')) {
            $query->where('client_id', $request->user()->client_id);
        }

        if ($request->filled('equipment')) {
            $query->where('equipment', 'like', '%'.$request->equipment.'%');
        }

        $images = $query->paginate(20);

        return $this->success(['images' => $images]);
    }

    public function store(StoreImageRequest $request)
    {
        $data = $request->validated();

        $image = Image::create([
            'client_id' => $data['client_id'],
            'uploaded_by' => $request->user()->id,
            'equipment' => $data['equipment'] ?? null,
            'description' => $data['description'] ?? null,
            'taken_at' => $data['taken_at'] ?? null,
        ]);

        $image->addMediaFromRequest('image')->toMediaCollection('images');

        return $this->success(['image' => $image], 'Imagem carregada.', 201);
    }

    public function show(Image $image)
    {
        $this->authorize('view', $image);

        return $this->success(['image' => $image]);
    }

    public function destroy(Image $image)
    {
        $this->authorize('delete', $image);

        $image->delete();

        return $this->success([], 'Imagem removida.');
    }
}
