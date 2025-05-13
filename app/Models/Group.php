<?php

namespace App\Models;

use Coolsam\NestedComments\Concerns\HasComments;
use Coolsam\NestedComments\Concerns\HasReactions;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasComments;
    use HasReactions;

    protected $fillable = [
        'name',
        'room_id',
    ];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}
