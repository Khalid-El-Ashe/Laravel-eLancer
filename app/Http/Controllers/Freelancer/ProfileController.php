<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // is return the current authenticated user
        $profile = $user->freelancer;
        $user->freelancer->birth_date?->format('d/M/Y');
        // optional($user->freelancer->birth_date?->format('d/M/Y')); // to be this value (birth_date) is optional if is null
        return view('freelancer.profile.edit', ['user' => $user, 'profile' => $profile]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'profile_photo' => [
                'nullable',
                'mimes:jpg,jpeg',
                // 'dimensions:min_width=200,min_height=200,max_height=1000,max_width=1000',
            ],
            'country' => ['required', 'string', 'size:2'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'hourly_rate' => ['nullable', 'min:5']
        ]);

        $user = Auth::user();

        /**
         * @var mixed
         * Old Photo Path
         * Used to delete the old photo after update
         */
        $old_photo_path = $user->freelancer->profile_photo_path;
        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'country'    => $request->country,
            'title'      => $request->title,
            'description' => $request->description,
            'hourly_rate' => $request->hourly_rate
        ];

        if ($request->hasFile('profile_photo')) {
            // $file = $request->file('profile_photo');

            // store in storage/app/public/profile_photos
            $filepath = $request->file('profile_photo')->store('profile_photos', ['disk' => 'public']);

            $data['profile_photo_path'] = $filepath;
        }

        // dd($request->all(), gettype($request->all()), $data);
        $user->freelancer()->updateOrCreate(['user_id' => $user->id], $data);

        /**
         * Update User Name
         * First Name + Last Name
         * if you want to change only the first name or last name
         */
        $user->forceFill(
            [
                'name' => $request->input('first_name') . ' ' . $request->input('last_name')
            ]
        )->save();

        /**
         * Delete Old Photo
         * if new photo uploaded
         */
        if ($old_photo_path && isset($data['profile_photo_path'])) {
            Storage::disk('public')->delete($old_photo_path);
        }

        return redirect()->route('freelancer.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
