<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class scheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::all();
        return view("schedules.index", compact("schedules"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("schedules.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'scheduleName' => 'required|string|max:255|unique:schedules,name',
            'days' => 'required|array|min:1',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
        ]);
        // Convert days array into a CSV string
        $daysCsv = implode(',', $request->days);
        // Create a new schedule
        /* $schedule = new \App\Models\Schedule([
            'name' => $data['scheduleName'],
            'start_time' => $data['startTime'],
            'end_time' => $data['endTime'],
            'days_of_week' => $daysCsv,
        ]); */
        $schedule = new Schedule();
        $schedule->name = $data['scheduleName'];
        $schedule->start_time = $data['startTime'];
        $schedule->end_time = $data['endTime'];
        $schedule->days_of_week = $daysCsv;
        $schedule->save();

        // Redirect or respond according to your application's needs
        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schedule = Schedule::with("employees")->findOrFail($id);
        return view('schedules.show', compact('schedule'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'scheduleName' => 'required|string|max:255',
            'days' => 'required|array|min:1',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->name = $data['scheduleName'];
        $schedule->start_time = $data['startTime'];
        $schedule->end_time = $data['endTime'];
        $schedule->days_of_week = implode(',', $data['days']);
        $schedule->update();


        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully!');
    }

    public function assignedEmployees(string $id)
    {
        // Assuming there's a many-to-many relationship and employees are related via a pivot table
        $schedule = Schedule::findOrFail($id);
        $employees = $schedule->employees()->paginate(10); // Paginate with 10 items per page
        return view('schedules.assignedEmployees', compact('schedule', 'employees'));
    }


    public function showStatistics()
    {
        $schedules = Schedule::with(['employees.position'])->get();

        $scheduleStats = $schedules->map(function ($schedule) {
            $averageSalary = $schedule->employees->avg('salary');
            $positionsCount = $schedule->employees
                ->when($schedule->employees->isNotEmpty(), function ($collection) {
                    return $collection->groupBy('position_id')
                        ->mapWithKeys(function ($item, $key) {
                            return [$item->first()->position->name => $item->count()];
                        });
                }, function () {
                    return collect([]);
                });

            return [
                'name' => $schedule->name,
                'employeeCount' => $schedule->employees->count(),
                'averageSalary' => $averageSalary,
                'positionsCount' => $positionsCount
            ];
        });

        $totalEmployees = $schedules->sum(function ($schedule) {
            return $schedule->employees->count();
        });
        $highestPayingSchedule = $scheduleStats->sortByDesc('averageSalary')->first();
        $lowestPayingSchedule = $scheduleStats->sortBy('averageSalary')->first();

        return view('schedules.showStatistics', compact('schedules','scheduleStats', 'totalEmployees', 'highestPayingSchedule', 'lowestPayingSchedule'));
    }
}


