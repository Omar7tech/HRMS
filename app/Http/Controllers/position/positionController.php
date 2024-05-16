<?php

namespace App\Http\Controllers\position;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class positionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Position::all();
        $salaries = $data->pluck('salary');
        return view("positions.index", compact("data" , "salaries"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            "name" => "required",
            "salary" => "required|numeric"
        ]);

        // Create a new model instance with the validated data
        $position = new Position();
        $position->fill($data);
        $position->save();
        // Optionally, you can return a response to the user
        return redirect()->route("positions.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Position::findOrFail($id);
        return view("positions.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->validate([
            "name" => "required",
            "salary" => "required|numeric"
        ]);
        Position::where("id", $id)->update($data);
        return redirect()->route("positions.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data = Position::findOrFail($id);
        return view("positions.delete", compact("data"));
    }

    public function destroy(string $id): RedirectResponse
    {
        Position::where("id", $id)->delete();
        return redirect()->route("positions.index");
    }

    public function showEmployeeByPosition(Request $request, $positionId)
    {
        if ($request->missing('status')) {
            return back(); // Redirect back if no status parameter is provided
        }

        $status = $request->query('status');
        $training_id = null; // Initialize with null

        // Map textual status to training_id values
        switch ($status) {
            case "employee":
                $training_id = 0;
                break;
            case "trainee":
                $training_id = 1;
                break;
            case "trained":
                $training_id = 2; // This should likely be 2 if it's different from "employee"
                break;
            default:
                return back(); // Redirect back if invalid status is provided
        }

        $position = Position::findOrFail($positionId);
        $employees = $position->all_employees()->where('training', $training_id)->paginate(10);

        return view('positions.showEmployees', compact('position', 'employees', 'training_id'));
    }
}
