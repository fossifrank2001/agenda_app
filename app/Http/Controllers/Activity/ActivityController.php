<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $query = Activity::query();

        // Filter by name or place
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('place', 'like', '%' . $searchTerm . '%');
        }

        if ($request->has('start_date') && !empty($request->input('start_date'))) {
            $startDate = $request->input('start_date');
            $query->whereDate('start_time', '>=', $startDate);
        }

        if ($request->has('end_date') && !empty($request->input('end_date'))) {
            $endDate = $request->input('end_date');
            $query->whereDate('end_time', '<=', $endDate);
        }

        if ($request->has('group_id') && !empty($request->input('group_id'))) {
            $groupId = $request->input('group_id');
//            dd($groupId);
            $query->where('group_id', (int)$groupId);
        }

        if ($request->has('place') && !empty($request->input('place'))) {
            $place = $request->input('place');
            $query->where('place', 'like', '%' . $place . '%');
        }

        $activities = $query
            ->with('group')
            ->orderByDesc('id')
            ->paginate(25);

        $groups = Group::all();

        return view('dashboard.activities.index', [
            'activities' => $activities,
            'groups' => $groups,
            'currentFilters' => [
                'group_id' => $request->input('group_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'search' => $request->input('search'),
            ],
        ]);

    }

    /**
     * Show the form for creating a new activity.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $groups = Group::all();
        return view('dashboard.activities.create', compact('groups'));
    }

    /**
     * Store a newly created activity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group_id' => 'required|exists:groups,id',
                'name' => 'required|min:3|string|max:255',
                'place' => 'nullable|min:2|string',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
            ]);

            if ($validator->fails()) {
                redirect()->back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();

            Activity::create($request->all());

            DB::commit();
            return to_route('activities')->with('success', 'Activity created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return to_route('activities')->with('error', 'Failed to create activity.');
        }
    }

    /**
     * Display the specified activity.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\View\View
     */
    public function show(Activity $activity)
    {
        $activity->load('group.users');
        return view('dashboard.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\View\View
     */
    public function edit(Activity $activity)
    {
        $groups = Group::all();
        return view('dashboard.activities.edit', compact('activity','groups'));
    }

    /**
     * Update the specified activity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'name' => 'required|string|max:255',
            'place' => 'nullable|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $activity->update($request->all());

        return to_route('activities')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified activity from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return to_route('activities')->with('success', 'Activity deleted successfully.');
    }
}
