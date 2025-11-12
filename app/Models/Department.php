<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'department_id';
    protected $guarded = ['department_id'];

    public function positions()
    {
        return $this->hasMany(Position::class, 'department_id', 'department_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'department_id');
    }
}
