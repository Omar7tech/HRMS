<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class VacationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Vacation::with('employee');

        if ($request->has('upcoming') && $request->upcoming == 'true') {
            $query->where('start_date', '>', Carbon::today());
        } elseif ($request->has('ongoing') && $request->ongoing == 'true') {
            $query->where('start_date', '<=', Carbon::today())
                ->where('end_date', '>=', Carbon::today());
        } elseif ($request->has('past') && $request->past == 'true') {
            $query->where('end_date', '<', Carbon::today());
        } elseif ($request->has('all')) {
            // No additional query modifications, show all including past
        } else {
            // Default view excludes past vacations
            $query->where('end_date', '>=', Carbon::today());
        }

        $vacations = $query->paginate(10);
        return view('vacations.index', compact('vacations'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vacations.create');
    }

    public function showStats()
    {

        return view("vacations.showstats");
    }



    public function statistics()
    {
        $vacationsPerMonth = DB::table('vacations')
            ->selectRaw('MONTH(start_date) as month, COUNT(*) as count')
            ->whereYear('start_date', Carbon::now()->year)
            ->groupBy('month')
            ->get();

        $vacationStatus = DB::table('vacations')
            ->selectRaw("CASE
                        WHEN vacations.start_date > CURDATE() THEN 'Upcoming'
                        WHEN vacations.end_date < CURDATE() THEN 'Past'
                        ELSE 'Ongoing'
                    END as status, COUNT(*) as count")
            ->groupBy('status')
            ->get();

        $mostPastVacations = DB::table('vacations')
            ->join('employees', 'vacations.employee_id', '=', 'employees.id')
            ->select('employees.first_name', 'employees.last_name', DB::raw('COUNT(vacations.id) as total'))
            ->where('vacations.end_date', '<', Carbon::today())
            ->groupBy('employees.id', 'employees.first_name', 'employees.last_name')
            ->orderBy('total', 'desc')
            ->first();

        $longestVacation = DB::table('vacations')
            ->join('employees', 'vacations.employee_id', '=', 'employees.id')
            ->select('employees.first_name', 'employees.last_name', DB::raw('MAX(DATEDIFF(vacations.end_date, vacations.start_date)) as duration'))
            ->groupBy('employees.id', 'employees.first_name', 'employees.last_name')
            ->orderBy('duration', 'desc')
            ->first();

        return view('vacations.statistics', compact('vacationsPerMonth', 'vacationStatus', 'mostPastVacations', 'longestVacation'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Create a new vacation record
        Vacation::create($validatedData);

        // Redirect back or to another page with a success message
        return redirect()->route('vacations.index')->with('success', 'Vacation successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'end_date' => 'required|date|after_or_equal:today',
    ]);

    $vacation = Vacation::findOrFail($id);
    $vacation->end_date = $request->end_date;
    $vacation->save();

    return redirect()->route('vacations.index')->with('success', 'Vacation updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vacation = Vacation::findOrFail($id);
        $vacation->delete();

        return redirect()->route('vacations.index')->with('success', 'Vacation deleted successfully!');
    }



    public function getVacationStats()
    {
        $vacationsPerMonth = \DB::table('vacations')
            ->selectRaw('MONTH(start_date) as month, COUNT(*) as count')
            ->whereYear('start_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $vacationStatus = \DB::table('vacations')
            ->selectRaw("CASE
            WHEN start_date > CURRENT_DATE THEN 'Upcoming'
            WHEN end_date < CURRENT_DATE THEN 'Past'
            ELSE 'Ongoing'
            END as status, COUNT(*) as count")
            ->groupBy('status')
            ->get();

        return response()->json([
            'vacationsPerMonth' => $vacationsPerMonth,
            'vacationStatus' => $vacationStatus
        ]);
    }


}
