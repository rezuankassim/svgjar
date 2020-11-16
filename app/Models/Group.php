<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];

    public function getDateForHumansAttribute()
    {
        return $this->created_at->format('M, d Y');
    }

    public function icons()
    {
        return $this->hasMany(Icon::class);
    }
}
