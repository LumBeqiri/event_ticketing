<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ticket_number = (string) \Illuminate\Support\Str::ulid();
        });
    }
}
