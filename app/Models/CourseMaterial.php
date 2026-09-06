<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'file_attachment',
        'order_sequence',
    ];

    /**
     * Relasi ke Course pemilik materi.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
