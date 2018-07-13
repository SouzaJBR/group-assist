<?php

namespace App;

use App\Interop\Fullteaching\FullteachingClient;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer max_members
 */
class StudentGroup extends Model
{
    protected $fillable = ['group_manager_id','user_id', 'max_members', 'description',  'name'];

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members() {
        return $this->belongsToMany(User::class);
    }

    public function manager() {
        return $this->belongsTo(GroupManager::class, 'group_manager_id');
    }

    public function join(User $user) {
        if(!$user->hasRole('student'))
            return 1;

        if($this->max_members <= $this->members->count())
            return 2;

        if(!in_array($this->manager->id_course, array_column(FullteachingClient::getUserCourses($user), 'id')))
            return 3;

        try {
            $user->groups()->attach($this->id, ['group_manager_id' => $this->manager->id]);
        } catch (\Exception $e) {
            return 4;
        }
        return 0;
    }

    public function leave(User $user) {

        return $user->groups()->detach($this->id);

    }

}
