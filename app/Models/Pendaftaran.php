<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $guarded = [];

    public function referralLink()
    {
        return $this->belongsTo(ReferralLink::class, 'referral_code', 'code');
    }
}
