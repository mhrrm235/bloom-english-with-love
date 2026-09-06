<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webinar extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'slug',
        'description',
        'schedule_time',
        'duration_minutes',
        'meeting_link',
        'max_participants',
        'banner_image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'schedule_time' => 'datetime',
        ];
    }

    /**
     * Relasi ke Instructor / Pembuat Webinar.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Relasi ke Peserta (Student) yang mendaftar webinar ini.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'webinar_registrations')
                    ->withPivot('registered_at', 'status')
                    ->withTimestamps();
    }

    /**
     * Relasi ke pendaftaran (WebinarRegistration).
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(WebinarRegistration::class);
    }
}
