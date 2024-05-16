<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class UuidController extends Controller
{
    public function index()
    {
        return view("UUID.index");
    }

    public function checkUuid(Request $request)
{
    $uuid = $request->input('uuid');
    if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid)) {
        return response()->json(['message' => 'Invalid UUID format.'], 422);
    }

    $employee = Employee::where('uuid', $uuid)->first();
    if ($employee) {
        return response()->json([
            'exists' => true,
            'message' => 'Employee found',
            'employee' => $employee->toArray() // Include all employee data
        ]);
    } else {
        return response()->json(['message' => 'UUID does not exist.'], 404);
    }
}


}


