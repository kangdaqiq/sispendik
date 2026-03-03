<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralLink extends Model
{
    protected $fillable = ['code', 'nama', 'keterangan', 'created_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'referral_code', 'code');
    }
}
