<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateForHumansAttribute()
    {
        return $this->created_at->format('M, d Y');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
