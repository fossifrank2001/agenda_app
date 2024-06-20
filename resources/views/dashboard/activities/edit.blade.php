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

                <div class="card">
                    <div  class="card-body">
                        <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-10 mx-auto">
                            <form method="POST" class="row" action="{{ route('activity_update', $activity->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-xs-12 col-md-4">
                                    <x-forms.input id="name" label="Name*" type="text" :value="$activity->name" required/>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <x-forms.input id="place" label="Place*" type="text" :value="$activity->place" required/>
                                </div>
                                <div class="col-xs-12 col-md-4">
{{--                                    @dd($activity->group_id)--}}
                                    <div class="mb-3">
                                        <label for="group_id" class="form-label">Select Group*</label>
                                        <select id="group_id" name="group_id" class="form-select">
                                            <option value="">Select Group</option>
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}" {{ $activity->group_id == $group->id ? 'selected' : '' }}>
                                                    {{ $group->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('group_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12">
                                    <x-forms.textarea id="descriptions" label="Description" type="textarea" :value="$activity->description"/>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <input type="text" id="start_time" class="form-control datetimepicker-input @error('start_time') is-invalid @enderror" data-target="#start_time" name="start_time" value="{{ old('start_time', \Illuminate\Support\Carbon::make($activity->start_time)->format('Y-m-d H:i:s')) }}" required/>
                                        @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="end_time" class="form-label">End Time</label>
                                        <input type="text" id="end_time" class="form-control datetimepicker-input @error('end_time') is-invalid @enderror" data-target="#end_time" name="end_time" value="{{ old('end_time', \Illuminate\Support\Carbon::make($activity->end_time)->format('Y-m-d H:i:s')) }}" required/>
                                        @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 my-4">
                                    <button type="submit" class="btn btn-primary w-100">Update Activity</button>
                                </div>
                            </form>
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
