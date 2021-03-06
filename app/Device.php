<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Device extends Authenticatable {
    protected $table = "perangkat";
    protected $primaryKey = "kode_perangkat";
    public $incrementing = false;
    public $timestamps = false;
    public $remember = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_perangkat', 'kata_sandi_perangkat',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getAuthPassword() {
      return $this->kata_sandi_perangkat;
    }
}
