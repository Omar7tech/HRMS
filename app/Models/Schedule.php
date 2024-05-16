<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
protected $fillable = ["name" , "start_date" , "end_date" , "days_of_week"];
    // app/Models/Schedule.php

public function employees()
{
    return $this->hasMany(Employee::class);
}

}
