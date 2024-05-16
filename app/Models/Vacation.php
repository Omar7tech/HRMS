<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'start_date', 'end_date'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];    /**
     * Get the employee that owns the vacation.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }



}
