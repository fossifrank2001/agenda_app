<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone', 'like', '%' . $searchTerm . '%');
        }



        $users = $query
            ->orderByDesc('id')
            ->paginate($request->input('per_page', 25), ['*'], 'page');

        return view('dashboard.users.index', [
            'users' => $users,
            'currentFilters' => [
                'search' => $request->input('search'),
                'per_page' => $request->input('per_page'),
            ],
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:users,email',
                'phone' => 'nullable|string|regex:/^6\d{8}$/|unique:users,phone',
            ]);

            // Check if either email or phone is provided
            if (empty($request->email) && empty($request->phone)) {
                return back()->withErrors([
                    'email' => 'Either email or phone must be provided.',
                    'phone' => 'Either email or phone must be provided.',
                ])->withInput();
            }

            $password = 'Agenda@2024';

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => User::MEMBER,
                'phone' => $request->phone,
                'password' => Hash::make($password),
            ]);

            DB::commit();

            return to_route('users')->with('success', 'Member added successfully.');

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Failed to create member: ' . $e->getMessage(), ['exception' => $e]);

            return to_route('users')->with('error', 'Failed to create member.');
        }
    }


    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable',
                'string',
                'regex:/^6\d{8}$/',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => ['required', 'string', Rule::in([User::MEMBER, User::ADMIN])],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return to_route('users')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route('users')->with('success', 'User deleted successfully.');
    }

}

