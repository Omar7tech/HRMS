<?php

namespace App\Http\Controllers\trainee;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class traineeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        // Query to fetch all employees
        $query = Employee::query();
        // Apply the condition for employees under training
        $query->where("training", 1);
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
        // Paginate the results
        $data = $query->paginate(10);
        return view("private.trainee.index", compact("data"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function trainedIndex(Request $request)
    {
        $search = $request->query('search');
        // Query to fetch all employees
        $query = Employee::query();
        // Apply the condition for employees under training
        $query->where("training", 2);
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
        // Paginate the results
        $data = $query->paginate(10);
        return view("private.trainee.trained", compact("data"));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
            ->where('training', 1)
            ->firstOrFail();
        $schedules = Schedule::all();
        $backUrl = url()->previous();
        return view("private.employee.show", compact(["employee", "schedules" , "backUrl"]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Employee::findOrFail($id);
        $positions = Position::all();
        return view("private.trainee.edit", compact(["data", "positions"]));
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
        return redirect()->route('trainee.show', ["trainee" => $id])->with('successEdit', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function confirm(string $id)
    {
        if (!is_numeric($id)) {
            return redirect()->route("trainee.index");
        }
        $data = Employee::whereIn('training', [1, 2])->findOrFail($id);
        return view("private.trainee.onboard-confirmation", compact("data"));
    }

    public function hire(string $id)
    {
        $data = Employee::whereIn('training', [1, 2])->findOrFail($id);
        $data->training = 0;
        $data->start_date = now();
        $data->update();
        return redirect()->route("employee.index");
    }

    public function end_training(string $id)
    {
        if (!is_numeric($id)) {
            return redirect()->route("trainee.index");
        }
        $data = Employee::where("training", 1)->findOrFail($id);
        return view("private.trainee.end-training", compact("data"));
    }



    public function downloadEndTrainingPdf($id)
    {
        $trainee = Employee::findOrFail($id);
        $pdf = PDF::loadView('private.trainee.pdf.endTraining', compact('trainee'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('end-training-certificate-' . $trainee->last_name . '.pdf');
    }
    public function endTraining(Request $request, $id)
    {
        $trainee = Employee::where("training", 1)->where('id', $id)->firstOrFail();
        $trainee->training = 2;
        $trainee->save(); // Save the change before deleting
        return redirect()->route("trainee.index");
    }
    public function endTrainingShow(string $id)
    {
        $trainee = Employee::findOrFail($id);
        return view("private.trainee.end-training", compact("trainee"));
    }

    public function showTrained(string $id)
    {
        if (!is_numeric($id)) {
            return back();
        }
        $trained = Employee::where("training", 2)->findOrFail($id);
        return view("private.trainee.showTrained", compact("trained"));
    }


}
