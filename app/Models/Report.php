<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Report extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const TYPE_INSPECTION = 'Inspeção';
    public const TYPE_MAINTENANCE = 'Manutenção';
    public const TYPE_AUDIT = 'Auditoria';
    public const TYPE_VISIT = 'Visita Técnica';

    protected $fillable = [
        'client_id',
        'uploaded_by',
        'title',
        'description',
        'report_type',
        'reference_date',
    ];

    protected $casts = [
        'reference_date' => 'date',
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
