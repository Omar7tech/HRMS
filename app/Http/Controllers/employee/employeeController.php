<?php



namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Employee::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->has('position') && $request->position != '') {
            $query->where('position_id', $request->position);
        }

        if ($request->has('salary_sort') && in_array($request->salary_sort, ['asc', 'desc'])) {
            $query->orderBy('salary', $request->salary_sort);
        }
        $maxSalaries = DB::table('employees')
            ->where("training", 0)
            ->select('position_id', DB::raw('MAX(salary) as max_salary'))
            ->groupBy('position_id')
            ->pluck('max_salary', 'position_id');

        $query->where("training", 0);
        $data = $query->paginate(15);
        return view("private.employee.index", compact("data", "maxSalaries"));
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::all();
        return view("private.employee.create", compact("positions"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployee $request)
    {
        $data = $request->validated();

        if (isset($data['training'])) {
            if ($data['training'] == "on") {
                $data['training'] = 1;
            }
        } else {
            $data['training'] = 0;
        }
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->storePublicly('cv', 'public');
        }
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storePublicly('images', 'public');
        }

        $employee = new Employee();
        $employee->fill($data);
        $employee->cv = $cvPath;
        $employee->image = $imagePath;
        $employee->position_id = $request->input('position');
        $employee->start_date = now();
        $employee->save();
        return redirect()->route('employee.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!is_numeric($id)) {
            return redirect()->route("employee.index");
        }
        $employee = Employee::where('id', $id)
            ->where('training', 0)
            ->with('vacations')
            ->firstOrFail();
        $schedules = Schedule::all();
        $backUrl = url()->previous();
        return view("private.employee.show", compact(["employee", "schedules", "backUrl"]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Employee::findOrFail($id);
        $positions = Position::all();
        return view("private.employee.edit", compact(["data", "positions"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployee $request, string $id)
    {
        $data = $request->validated();
        $employee = Employee::findOrFail($id);
        $employee->position_id = $data['position'];

        if ($request->hasFile('cv')) {
            if ($employee->cv) {
                Storage::disk('public')->delete($employee->cv);
            }
            $cvPath = $request->file('cv')->storePublicly('cv', 'public');
            $data["cv"] = $cvPath;
        }

        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::disk('public')->delete($employee->image);
            }
            $imagePath = $request->file('image')->storePublicly('images', 'public');
            $data["image"] = $imagePath;
        }
        $employee->update($data);
        return redirect()->route('employee.show', ["employee" => $id])->with('successEdit', 'Employee updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Employee::destroy($id);
        return redirect()->route("employee.index");
    }

    public function showEmployeeStats()
    {
        $totalEmployees = Employee::count();
        // Training status counts
        $trainingInProgress = Employee::where('training', 1)->count();
        $trainingCompleted = Employee::where('training', 2)->count();
        $trainingNotStarted = Employee::where('training', 0)->count();
        // Demographic statistics
        $genderDistribution = Employee::select('gender')
            ->groupBy('gender')
            ->selectRaw('COUNT(*) as count')
            ->pluck('count', 'gender');
        $nationalityDistribution = Employee::select('nationality')
            ->groupBy('nationality')
            ->selectRaw('COUNT(*) as count')
            ->pluck('count', 'nationality');
        // Age distribution
        $ageDistribution = Employee::selectRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age')
            ->get()
            ->groupBy(function ($employee) {
                if ($employee->age >= 50) {
                    return '50+';
                } elseif ($employee->age >= 30) {
                    return '30-49';
                } else {
                    return 'Under 30';
                }
            })
            ->map->count();
        // Salary and employment statistics
        $averageSalary = Employee::average('salary');
        $maxSalary = Employee::max('salary');
        $minSalary = Employee::min('salary');
        // Tenure calculation
        $averageTenure = Employee::whereNotNull('start_date')
            ->selectRaw('AVG(TIMESTAMPDIFF(MONTH, start_date, COALESCE(deleted_at, CURDATE()))) AS average_tenure')
            ->value('average_tenure');
        // Position distribution
        $positionDistribution = Employee::with('position')
            ->get()
            ->groupBy('position.name')
            ->map->count();
        // Employment status
        $activeEmployees = Employee::whereNull('deleted_at')->count();
        $inactiveEmployees = Employee::whereNotNull('deleted_at')->count();
        // Latest hires and exits
        $latestHires = Employee::orderBy('created_at', 'desc')->take(5)->get();
        $latestExits = Employee::onlyTrashed()->orderBy('deleted_at', 'desc')->take(5)->get();

        $positionCounts = Employee::with('position') // Preload position data
            ->get()
            ->groupBy('position.name') // Ensure 'position' is correctly related and 'name' exists
            ->map->count();
        $positionDistribution = Employee::with('position')
            ->get()
            ->groupBy('position.name')
            ->map(function ($group) {
                return $group->count();
            });
        $nationalityDistribution = Employee::groupBy('nationality')
            ->select('nationality', DB::raw('COUNT(*) as count'))
            ->pluck('count', 'nationality');
        return view(
            'private.employee.statistics',
            compact(
                'nationalityDistribution',
                'positionCounts',
                'totalEmployees',
                'trainingInProgress',
                'trainingCompleted',
                'trainingNotStarted',
                'genderDistribution',
                'nationalityDistribution',
                'ageDistribution',
                'averageSalary',
                'maxSalary',
                'minSalary',
                'averageTenure',
                'positionDistribution',
                'activeEmployees',
                'inactiveEmployees',
                'latestHires',
                'latestExits'
            )
        );

    }

    public function showTerminated(Request $request)
    {
        $search = $request->query('search');
        // Query to fetch all employees
        $query = Employee::onlyTrashed()->where('training', 0);
        // Check if there is a search query
        if ($search) {
            // Query to search for employees based on first_name, last_name, or email
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhereHas('position', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhere('email', 'like', "%$search%");
            });
        }
        // Apply the condition for employees not under training
        $query->where("training", 0);
        // Paginate the results
        $data = $query->paginate(10);
        return view("private.employee.terminated", compact("data"));
    }

    public function showTerminatedEmployee($id)
    {
        // Ensure the ID is numeric to prevent SQL injection or unexpected errors
        if (!is_numeric($id)) {
            return redirect()->route("employee.terminated")->with('error', 'Invalid employee ID.');
        }
        // Retrieve only the terminated (soft-deleted) employee with the specific conditions
        $employee = Employee::onlyTrashed()
            ->where('id', $id)
            ->where('training', 0)
            ->first();
        // Check if an employee was found
        if (!$employee) {
            return redirect()->route("employee.terminated")->with('error', 'No terminated employee found with the given ID.');
        }
        // If an employee is found, pass it to the view
        return view("private.employee.showTerminated", compact("employee"));
    }
    public function search(Request $request)
    {
        $query = $request->input('search');

        if (empty($query)) {
            return response()->json([]);
        }

        // Fetch employees where training is either 0 or 1
        $employees = Employee::where(function ($q) use ($query) {
            $q->where('first_name', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%");
        })
            ->where('training', '<>', 2)  // Exclude employees where training is 2
            ->get(['id', 'first_name', 'last_name', 'email']);

        return response()->json($employees);
    }






    public function restore($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $employee->restore();

        return response()->json(['message' => 'Employee restored successfully!']);
    }

    public function unAssignSchedule(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->schedule_id = null;
        $employee->update();
        if ($employee->training == 0) {
            return redirect()->route('employee.show', ["employee" => $id])->with('successEdit', 'Employee updated successfully.');
        } elseif ($employee->training == 1) {
            return redirect()->route('trainee.show', ["trainee" => $id])->with('successEdit', 'Employee updated successfully.');
        }
    }
    public function AssignSchedule(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->schedule_id = $request->input("id");
        $employee->update();
        if ($employee->training == 0) {
            return redirect()->route('employee.show', ["employee" => $id])->with('successEdit', 'Employee updated successfully.');
        } elseif ($employee->training == 1) {
            return redirect()->route('trainee.show', ["trainee" => $id])->with('successEdit', 'Employee updated successfully.');
        }
    }

    public function uploadCv(Request $request, $id)
    {
        $request->validate([
            'cvFile' => 'required|file|mimes:pdf|max:2048', // 2MB max file size and only PDF
        ]);

        $employee = Employee::findOrFail($id);

        // Handle File Upload
        if ($request->hasFile('cvFile')) {
            // Delete old CV if it exists
            if ($employee->cv && Storage::disk('public')->exists($employee->cv)) {
                Storage::disk('public')->delete($employee->cv);
            }

            // Store new file
            $path = $request->file('cvFile')->store('cv', 'public');
            $employee->cv = $path;
            $employee->save();

            return back()->with('success', 'CV uploaded successfully.');
        }

        return back()->with('error', 'There was an issue uploading the CV.');
    }
    public function uploadImage(Request $request, $id)
    {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image', // 2MB max file size and only image files
        ]);

        // Retrieve the employee by ID
        $employee = Employee::findOrFail($id);

        // Handle the image file upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists in storage
            if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }

            // Store the new image file
            $path = $request->file('image')->store('images', 'public');
            $employee->image = $path;
            $employee->save();

            // Redirect back with success message
            return back()->with('success', 'Image uploaded successfully.');
        }

        // Redirect back with error message if image wasn't uploaded
        return back()->with('error', 'There was an issue uploading the image.');
    }



    public function deleteCv($id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);

        if ($employee->cv && Storage::disk('public')->exists($employee->cv)) {
            Storage::disk('public')->delete($employee->cv);
            $employee->cv = null;
            $employee->save();
            return back();
        }
        return back();
    }
    public function deleteImage($id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);
        if ($employee->image && Storage::disk('public')->exists($employee->image)) {
            Storage::disk('public')->delete($employee->image);
            $employee->image = null;
            $employee->save();
            return back()->with('success', 'Image deleted successfully.');
        }
        return back()->with('error', 'No image found to delete.');
    }

    public function home()
    {
        $totalEmployees = Employee::count();
        $employee = Employee::where('training', 0)->count();
        $inTraining = Employee::where('training', 1)->count();
        $trained = Employee::where('training', 2)->count();
        $terminated = Employee::onlyTrashed()->count();

        // Fetch detailed position stats
        $positions = Position::withCount(['all_employees', 'employees', 'trainees', 'trained'])->get();

        // Last added 3 employees
        $lastAddedEmployees = Employee::where("training", 0)->latest()->take(3)->get();

        // Top 3 oldest employees
        $oldestEmployees = Employee::where("training", 0)->orderBy('start_date')->take(3)->get();

        // Top 3 employees with the highest salaries
        $highestSalaryEmployees = Employee::where("training", 0)->orderBy('salary', 'desc')->take(3)->get();

        // Top 3 employees with the lowest salaries
        $lowestSalaryEmployees = Employee::where("training", 0)->orderBy('salary')->take(3)->get();

        // Calculate average age for each position
        $averageAges = Position::with(['employees' => function ($query) {
            $query->selectRaw('position_id, AVG(TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())) as average_age')
                  ->groupBy('position_id');
        }])->get()->mapWithKeys(function ($position) {
            return [$position->name => $position->employees->first()->average_age ?? 0];
        });

        return view('private.home', compact(
            'totalEmployees', 'employee', 'inTraining', 'trained', 'terminated', 'positions',
            'lastAddedEmployees', 'oldestEmployees', 'highestSalaryEmployees', 'lowestSalaryEmployees',
            'averageAges'
        ));
    }



}





