<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupManager extends Model
{

    protected $fillable = ['id_course', 'id_owner', 'name', 'description'];
}
