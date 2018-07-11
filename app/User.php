<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Contracts\HasRoleAndPermission;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property mixed external_id
 */
class User extends Authenticatable implements JWTSubject, HasRoleAndPermission
{
    use  Notifiable;
    use \jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

    public function groups() {
        return $this->belongsToMany(StudentGroup::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'external_id', 'provider'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
