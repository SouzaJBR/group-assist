<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    protected $fillable = ['group_manager_id','user_id', 'max_students', 'description',  'name'];

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members() {
        return $this->belongsToMany(User::class);
    }

    public function manager() {
        return $this->belongsTo(GroupManager::class, 'group_manager_id');
    }

}
