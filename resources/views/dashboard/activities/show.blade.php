@extends('layouts.dashboard')

@section('title', 'Activities')

@section('content')

    @php
        /**
        * @var \Illuminate\Database\Eloquent\Collection<\App\Models\Group> $groups
        * @var \App\Models\Activity $activity
        */
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-utils.breadcrumb parent="Activities"  :child="$activity?->id ?? null" url="activities"/>
                <div class="align-items-center d-flex justify-content-between mb-4 ms-auto">
                    <a type="button" href="{{ route('activities') }}" class="btn btn-outline-primary d-flex align-items-center">
                        <i class="ti ti-arrow-back"></i>
                        <span class="ms-2">Back</span>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="">ACTIVITY DETAILS</h5>
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6 py-1"><strong class="fs-5">Name: </strong>{{$activity->name}}</div>
                                            <div class="col-xs-12 col-md-6 py-1"><strong class="fs-5">Place: </strong>{{$activity->place}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6 py-1"><strong class="fs-5">Start time: </strong>
                                                @if (\Carbon\Carbon::parse($activity->start_time)->format('H:i:s') == '00:00:00')
                                                    {{ \Carbon\Carbon::parse($activity->start_time)->format('d/m/Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($activity->start_time)->format('d/m/Y H:i:s') }}
                                                @endif
                                            </div>
                                            <div class="col-xs-12 col-md-6 py-1"><strong class="fs-5">End time: </strong>
                                                @if (\Carbon\Carbon::parse($activity->end_time)->format('H:i:s') == '00:00:00')
                                                    {{ \Carbon\Carbon::parse($activity->end_time)->format('d/m/Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($activity->end_time)->format('d/m/Y H:i:s') }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6 py-1">
                                                <strong class="fs-5">Status: </strong>
                                                @if ($activity->status === \App\Models\Activity::PROCCESSING)
                                                    <span class="badge text-bg-success">{{$activity->status}}</span>
                                                @else
                                                    <span class="badge text-bg-danger">{{$activity->status}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 py-1">
                                                <strong class="fs-5">Description: </strong>
                                                <div class="card p-0 m-0">
                                                    <div class="card-body">
                                                        {{ $activity->description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(auth()->user()->role == \App\Models\User::ADMIN)
                                            <div class="d-flex justify-content-end align-items-center">
                                                <a href="{{route('activity_edit', ['activity' => $activity->id])}}" class="btn btn-primary">Update Activity</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="">GROUP DETAILS</h5>
                                    <div class="row ">
                                        <div class="col-xs-12 col-md-9">
                                            <div class="p-3">
                                                <div class=" py-1"><strong class="fs-5">Name: </strong>{{$activity->group->name}}</div>
                                                <div class=" py-1"><strong class="fs-5">Description: </strong>{{$activity->group->description}}</div>
                                                <div class=" py-1"><strong class="fs-5">Created At: </strong>{{ \Carbon\Carbon::parse($activity->group->created_at)->format('d/m/Y H:i:s') }}</div>
                                                <div class=" py-1"><strong class="fs-5">Updated At: </strong>{{ \Carbon\Carbon::parse($activity->group->updated_at)->format('d/m/Y H:i:s') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-3">
                                            <img class="img-fluid" src="{{$activity->group->logo}}" style="height: auto; width: 100%"  alt="{{$activity->group->name}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="">MEMBERS OF GROUP</h5>
                                    <table id="activity-table" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($activity->group->users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No members found...</td>
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
