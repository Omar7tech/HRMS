<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModeratorController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('moderator.index', compact('admins'));
    }


    public function toggleActive(Request $request, $id)
    {
        \Log::info('Toggle request received for admin ID: ' . $id, ['is_active' => $request->input('is_active')]);

        try {
            $admin = User::find($id);

            if ($admin) {
                $admin->is_active = $request->input('is_active');
                $admin->save();

                \Log::info('Admin status updated successfully.', ['admin_id' => $id, 'is_active' => $admin->is_active]);

                return response()->json(['success' => true]);
            } else {
                \Log::error('Admin not found.', ['admin_id' => $id]);
                return response()->json(['success' => false, 'message' => 'Admin not found.'], 404);
            }
        } catch (\Exception $e) {
            \Log::error('An error occurred while updating admin status.', ['admin_id' => $id, 'exception' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    public function addAdmin(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6|max:255',
        ], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
        ]);

        // Create a new admin
        $admin = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role' => 'admin',
        ]);

        // Optionally, redirect back with a success message
        return redirect()->route('moderator.index')->with('success', 'Admin added successfully!');
    }



    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            // Add validation rules for other fields as needed
        ]);

        $admin = User::find($id);

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found.');
        }

        $admin->update($request->all());

        return redirect()->back()->with('success', 'Admin updated successfully.');
    }
    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->route('moderator.index')->with('success', 'Admin deleted successfully');
    }

    public function editAdmin($id)
    {
        $admin = User::where("role" , "admin")->findOrFail($id);
        return view('moderator.moderatorEdit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:20',
            'username' => 'required|string|max:255',
        ]);
        $admin = User::findOrFail($id);
        $admin->update($validatedData);
        return redirect()->route("moderator.index")->with('success', 'Admin details updated successfully.');
    }

}
