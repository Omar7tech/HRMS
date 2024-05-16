<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'national_id',
        'nationality',
        'gender',
        'date_of_birth',
        'email',
        'phone_number',
        'address',
        'salary',
        'emergency_contact',
        'cv',
        'image',
        'position_id', // Add position_id to fillable array
        'training',
        'start_date'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }


    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Check if the employee is currently on vacation.
     */
    public function isOnVacation()
    {
        $today = now()->toDateString();
        return $this->vacations()
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->exists();
    }


    protected static function boot()
    {
        parent::boot();

        // Generate UUID before creating a new record
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });

    }

    /**
     * Check if the employee has an upcoming vacation.
     *
     * @return bool
     */
    public function hasUpcomingVacation()
    {
        $today = now()->toDateString(); // Gets today's date

        // Check for vacations that start after today
        return $this->vacations()
            ->where('start_date', '>', $today) // Vacations that start after today
            ->exists();
    }


}
