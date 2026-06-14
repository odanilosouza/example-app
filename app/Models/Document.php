<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Document extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const CATEGORY_CONTRACTS = 'Contratos';
    public const CATEGORY_CERTIFICATES = 'Certificados';
    public const CATEGORY_REPORTS = 'Relatórios';
    public const CATEGORY_TECHNICAL = 'Documentos Técnicos';
    public const CATEGORY_OTHER = 'Outros';

    protected $fillable = [
        'client_id',
        'uploaded_by',
        'name',
        'category',
        'description',
        'reference_year',
        'mime_type',
        'size',
    ];

    protected $casts = [
        'reference_year' => 'integer',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
