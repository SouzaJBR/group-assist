<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    protected $fillable = ['user_id', 'max_students', 'description',  'name'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
