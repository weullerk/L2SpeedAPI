<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlympiadNobles extends Model
{
    protected $table = 'olympiad_nobles';

    public function character() {
        return $this->hasOne(Character::class, 'obj_Id', 'char_id');
    }

    public function class() {
        return $this->hasOne(ClassList::class, 'id', 'class_id');
    }
}
