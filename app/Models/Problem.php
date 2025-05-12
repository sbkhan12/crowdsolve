<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'category',
        'status', 'location', 'media_path'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

   public function comments() {
    return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
}

    public function updates() {
        return $this->hasMany(ProgressUpdate::class);
    }
    public function voteCount()
{
    return $this->votes()->selectRaw("problem_id,
        SUM(CASE WHEN type = 'up' THEN 1 ELSE 0 END) as upvotes,
        SUM(CASE WHEN type = 'down' THEN 1 ELSE 0 END) as downvotes")
        ->groupBy('problem_id');
}


}