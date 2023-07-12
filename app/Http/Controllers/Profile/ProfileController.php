<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return inertia('Profile/Index', [
            'user' => auth()->user(),
            'settings' => auth()->user()->settings,
            'mailer' => auth()->user()->mailer ?? [],
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $request->user()->update($request->validated());

        return redirect()->route('panel.profile.show')->with('success', 'Profile updated');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->user()->update([
            'password' => $request->password,
        ]);

        return redirect()->route('panel.profile.show')->with('success', 'Your password has been successfully changed!');
    }

    public function settings(Request $request)
    {
        $request->user()->update([
            'settings' => $request->input('settings'),
            'newsletter' => $request->input('newsletter', true),
            'mailer' => $request->input('mailer'),
        ]);

        ray(auth()->user()->toArray());

        ray($request->input('mailer'));

        return redirect()->route('panel.profile.show')->with('success', 'Profile settings updated');
    }
}
