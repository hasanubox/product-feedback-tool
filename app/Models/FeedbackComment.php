<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class FeedbackComment extends Model
{
    use HasFactory;
    protected $fillable = ['feedback_id','user_id','comment'];

    public function feedback(): BelongsTo
    {
        return $this->belongsTo(Feedback::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        // Convert the 'created_at' attribute to a Carbon instance
        $carbonDate = new Carbon($value);

        // Format the date as "d F, Y" (e.g., 15 October, 2023)
        return $carbonDate->format('d F, Y');
    }
}
