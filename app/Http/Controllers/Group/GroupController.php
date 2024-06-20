<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * List.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Group::query();

        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $groups = $query
            ->with('users')
            ->orderByDesc('id')
            ->paginate(25);

        $users = User::all();

        return view('dashboard.groups.index', compact('groups', 'users'));
    }

    /**
     * Store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GroupRequest $request)
    {
        try {
            $validator = $request->validated();

            DB::beginTransaction();

            $group = new Group();
            $group->name = $request->name;
            $group->description = $request->description;

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $imagePath = Storage::disk('public')->putFile('logos', $image);
                $group->logo = $imagePath;
            }

            $group->save();

            if ($request->filled('users')) {
                $group->users()->attach($request->input('users'));
            }

            DB::commit();

            return to_route('groups.index')->with('success', 'Group created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return to_route('groups.index')->with('error', 'Failed to create group.');
        }
    }


    /**
     * Update.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GroupRequest $request, Group $group)
    {
        try {
            $validator = $request->validated();

            DB::beginTransaction();

            $group->name = $request->name;
            $group->description = $request->description;

            if ($request->hasFile('logo')) {
                if ($group->logo && Storage::disk('public')->exists($group->logo)) {
                    Storage::disk('public')->delete($group->logo);
                }

                // Store new logo
                $image = $request->file('logo');
                $imagePath = Storage::disk('public')->putFile('logos', $image);
                $group->logo = $imagePath;
            }

            $group->save();

            if ($request->filled('users')) {
                $group->users()->sync($request->input('users'));
            } else {
                $group->users()->detach();
            }
            DB::commit();

            return to_route('groups.index')->with('success', 'Group updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return to_route('groups.index')->with('error', 'Failed to update group.');
        }
    }


    /**
     * Remove.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Group $group)
    {
        if ($group->logo) {
            Storage::disk('public')->delete($group->logo);
        }
        $group->users()->detach();
        $group->activities()->delete();
        $group->delete();
        return to_route('groups.index')->with('success', 'Group deleted successfully.');
    }
}

