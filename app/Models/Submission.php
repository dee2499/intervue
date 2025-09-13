<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_url',
        'candidate_id',
        'question_id',
    ];


    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
