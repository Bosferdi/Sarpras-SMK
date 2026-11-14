<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintFeedback extends Model
{
    use HasFactory;

    protected $table = 'complaint_feedbacks';

    // Izinkan kolom feedback dan notes masuk mass-assignment
    protected $fillable = [
        'complaint_id',
        'user_id',
        'feedback',
        'notes',
        'status_change',
    ];

    /**
     * Relasi ke aduan
     */
    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }

    /**
     * Relasi ke petugas yang merespon (dipakai di Controller & View)
     */
    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi fallback jika view memanggil user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
