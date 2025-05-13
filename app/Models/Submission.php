<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'group_id',
        'user_id',
        'file_path',
        'description',
        'created_by',
    ];
    public function group() {
        return $this->belongsTo(Group::class);
    }
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
