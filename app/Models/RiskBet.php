<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskBet extends Model
{
    use HasFactory;
    protected $table = "risk_bets";
    public function user()
    {
        return $this->belongsTo('App\Models\User'::class);
    }
}
