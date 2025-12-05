<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // is return the current authenticated user
        $profile = $user->freelancer;
        return view('freelancer.profile.edit', ['user' => $user, 'profile' => $profile]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
        ]);

        $user = Auth::user();
        $user->freelancer()->updateOrCreate([
            'user_id' => $user->id,
        ], $request->all());

        return redirect()->route('freelancer.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
