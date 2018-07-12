<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string description
 */
class GroupManager extends Model
{

    protected $fillable = ['id_course', 'id_owner', 'name', 'description'];

    public function owner() {
        return $this->belongsTo(User::class, 'id_owner');
    }

    public function groups() {
        return $this->hasMany(StudentGroup::class);
    }
}
