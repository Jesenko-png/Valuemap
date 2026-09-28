<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->orderBy('is_approved')->latest()->paginate(20),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(User::ROLES)],
            'is_approved' => ['required', 'boolean'],
        ]);

        if ($request->user()->is($user) && (! $data['is_approved'] || $data['role'] !== User::ROLE_MAIN_ADMIN)) {
            return back()->withErrors(['role' => 'You cannot remove your own main administrator access.']);
        }

        $approved = (bool) $data['is_approved'];
        $user->update([
            'role' => $data['role'],
            'requested_role' => $data['role'],
            'is_approved' => $approved,
            'is_admin' => in_array($data['role'], [User::ROLE_MAIN_ADMIN, User::ROLE_ADMIN], true) && $approved,
            'approved_at' => $approved ? now() : null,
            'approved_by' => $approved ? $request->user()->id : null,
        ]);

        return back()->with('success', 'User access updated.');
    }
}
