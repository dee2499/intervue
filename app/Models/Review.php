<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'score',
        'comments',
        'reviewer_id',
        'submission_id',
    ];


    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
