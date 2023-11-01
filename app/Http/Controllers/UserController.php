<?php

namespace App\Http\Controllers;

use App\Models\BdmUser;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::orderBy('created_at', 'DSEC')->get(['_id', 'name', 'email',  'status', 'created_at']);
        $users = BdmUser::orderBy('created_at', 'DSEC')->paginate(10);
        return view('user.index', compact('users'));
    }
    public function status($id)
    {
        try {
            $user = BdmUser::findOrFail($id);

            $user->status = $user->status === 'Active' ? 'InActive' : 'Active';
            $user->save();

            return redirect()->back()->with('success', 'User status updated successfully.');
        } catch (Exception $e) {
            // Handle exceptions and redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred while updating user status.');
        }
    }
}
