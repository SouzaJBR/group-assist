<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
