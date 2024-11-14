<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\Address;

class MemberController extends Controller
{
    /**
     * Show the list of members
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $users = User::latest()
            ->where('users.id', '!=', 1)
            ->get();

        $levels = config('constants.ACCESS_LEVELS');

        return view('admin.members.index', [
            'users'  => $users,
            'levels' => $levels,
        ]);
    }

    /**
     * update 
     * 
     * Edit a member record
     * 
     * @param Request $request 
     * @return null
     */
    public function update(User $user, Request $request)
    {
        $validated = $request->validate([
            'activated' => ['sometimes', 'boolean'],
        ]);

        if ($request->has('activated'))
        {
            $user->activated = $request->activated;
        }
        if ($request->has('access'))
        {
            $user->access = $request->access;
        }

        $user->save();

        if ($request->wantsJson())
        {
            $user = $user->toArray();

            $user['text'] = $user['activated'] == 1 ? _gettext('Yes') : _gettext('No');

            return response()->json($user);
        }
    }

    /**
     * destroy 
     * 
     * @param User $user 
     * @param Request $request 
     * @return null
     */
    public function destroy(User $user, Request $request)
    {
        // Delete the user settings
        $settings = UserSetting::where('user_id', $user->id)->delete();

        // Delete the user address
        $address = Address::where('user_id', $user->id)->delete();

        // Delete the user
        $user->delete();

        return redirect()->route('admin.members');
    }
}
