@extends('layouts.dashboard')

@section('title', 'Activities')

@section('content')

    @php
        /**
        * @var \Illuminate\Database\Eloquent\Collection<\App\Models\Group> $groups
        * @var \Illuminate\Database\Eloquent\Collection<\App\Models\Activity> $activities
        */
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-utils.breadcrumb parent="Activities" />
                <div class="card">
                    <div  class="card-body">
                        <div class="row align-items-center d-flex justify-content-between mb-4 ms-auto">
                            @if(auth()->user()->role == \App\Models\User::ADMIN)
                                <div class="col-xs-6 col-md-2">
                                    <a href="{{route('activity_create')}}" class="btn btn-primary d-flex align-items-center">
                                        <i class="ti ti-plus"></i>
                                        <span class="ms-2">Add an Activity</span>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-12 col-md-8">
                                <x-activity.filter-activities :groups="$groups" :currentFilters="$currentFilters" />
                            </div>
                        </div>
                        <div class="container">
                    <div  style="overflow-x: auto; max-width: 100% ">
                        <table id="activity-table" class="table table-striped table-bordered" style="width: 1350px">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Place</th>
                                <th>Status</th>
                                <th>Group</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ $activity->place }}</td>
                                    <td>
                                        @if ($activity->status === \App\Models\Activity::PROCCESSING)
                                            <span class="badge text-bg-success">{{$activity->status}}</span>
                                        @else
                                            <span class="badge text-bg-danger">{{$activity->status}}</span>
                                        @endif
                                    </td>
                                    <td>{{ $activity?->group->name }}</td>
                                    <td>
                                        @if (\Carbon\Carbon::parse($activity->start_time)->format('H:i:s') == '00:00:00')
                                            {{ \Carbon\Carbon::parse($activity->start_time)->format('d/m/Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($activity->start_time)->format('d/m/Y H:i:s') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (\Carbon\Carbon::parse($activity->end_time)->format('H:i:s') == '00:00:00')
                                            {{ \Carbon\Carbon::parse($activity->end_time)->format('d/m/Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($activity->end_time)->format('d/m/Y H:i:s') }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('activity_show', ['activity' =>$activity->id])}}" class="me-1">
                                            <i class="ti ti-eye text-dark"></i>
                                        </a>
                                        @if(auth()->user()->role == \App\Models\User::ADMIN)
                                            <a href="{{route('activity_edit', ['activity' =>$activity->id])}}" class="me-1">
                                                <i class="ti ti-pencil text-primary"></i>
                                            </a>
                                            <form action="{{ route('activity_destroy', ['activity' => $activity->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="me-1 btn btn-danger btn-circle">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Showing {{ $activities->firstItem() }} to {{ $activities->lastItem() }} of {{ $activities->total() }} entries</div>
                        <div>{!! $activities->appends(request()->input())->links("pagination::bootstrap-4") !!}</div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
