<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operate extends Model
{
    use HasFactory;
    protected $table = "operates";
    public function user()
    {
        return $this->belongsTo('App\Models\User'::class);
    }
}
