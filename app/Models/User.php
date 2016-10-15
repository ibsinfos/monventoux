<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

    protected $table = 'mv2016_deelnemers';
    protected $primaryKey = 'sadn_id';
    protected $hidden = ['password', 'remember_token'];

    public function timingCannibale()
    {
        return $this->hasOne('App\Models\TimingCannibale', 'persoon_id', 'sadn_id');
    }

    public function timingVentourist()
    {
        return $this->hasOne('App\Models\TimingVentourist', 'persoon_id', 'sadn_id');
    }

}
