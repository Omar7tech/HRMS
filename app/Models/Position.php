<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'salary',
    ];


    public function all_employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class)->where('training', 0);
    }

    public function trainees()
    {
        return $this->hasMany(Employee::class)->where('training', 1);
    }
    public function trained()
    {
        return $this->hasMany(Employee::class)->where('training', 2);
    }

}
