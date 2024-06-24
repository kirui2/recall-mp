<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index() {
        $admins = User::where('is_admin', false)->get();
        return view('admin.index', compact('admins'));
    }

    public function approve(Request $request) {
        $user = User::find($request->user_id);
        $user->is_admin = true;
        $user->save();
        return redirect()->back()->with('success', 'Admin approved successfully!');
    }
}
