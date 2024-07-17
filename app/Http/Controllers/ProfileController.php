<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\LogUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldData = $user->getOriginal();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $newData = $user->getAttributes();
        $user->save();

        $oldDataFormatted = "Name: {$oldData['name']}, Email: {$oldData['email']}, Username: {$oldData['username']}, NIM: {$oldData['nim']}, NIP: {$oldData['nip']}";
        $newDataFormatted = "Name: {$newData['name']}, Email: {$newData['email']}, Username: {$newData['username']}, NIM: {$newData['nim']}, NIP: {$newData['nip']}";

        // Log the changes
        LogUsers::create([
            'id_user'   => $user->id,
            'action'    => 'Update User Data',
            'detail'    => "Old Data:\n$oldDataFormatted\nUpdate to\nNew Data:\n$newDataFormatted",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
