<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class ProfileController extends Controller
{
    public function view(User $user)
    {
        $profile = $user->profile();
        $profile->books = $profile->books();
        return view('profile/view')->with('profile', $profile);
    }

    public function editPage(User $user)
    {
        $profile = $user->profile();
        $this->authorize('update', $profile);
        $user->profile = $profile;
        return view('profile/edit')->with('user', $user);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'Name' => ['required', 'max:15'],
            'description' => '',
            'img' => 'image'
        ]);

        $profile = $user->profile();
        $this->authorize('update', $profile);

        if (request()->hasFile('img')) {
            $filename = date('Y_m_d_U') . request('img')->getClientOriginalName();
            $path = request('img')->storeAs('public/profiles', $filename);
            $data = array_merge(
                $data,
                ['img' => $path]
            );
        }

        auth()->user()->profile->update($data);

        return redirect('home');
    }
}
