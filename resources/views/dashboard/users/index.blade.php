@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')

    @php
     /**
     * @var \Illuminate\Database\Eloquent\Collection<\App\Models\User> $users
     */
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-utils.breadcrumb parent="Members" />
                <div class="my-4">
                    <button type="button" class="btn btn-primary d-flex align-items-center my-2" data-bs-toggle="modal"
                                          data-bs-target="#addGroupModal">
                        <i class="ti ti-plus"></i>
                        <span class="ms-2">Add a member</span>
                    </button>
                    <form action="{{ route('users') }}" method="GET" class="input-group ">
                        <div class="row w-100 d-flex justify-content-between align-items-center">
                            <div class="col-xs-12 col-md-6 d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="">Show</div>
                                    <select class="form-select mr-sm-2 mx-1" id="inlineFormCustomSelect">
                                        @foreach(collect([10, 15, 25, 50]) as $index => $selectItem)
                                            <option @if($currentFilters['per_page'] == $selectItem) value="{{ $selectItem }}" selected @endif value="{{ request()->input('per_page', 10) }}">{{$selectItem}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 d-flex justify-content-end">
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control" name="search" placeholder="Search..."
                                           value="{{$currentFilters['search']}}">

                                    <button class="btn btn-primary" type="submit">
                                        <i class="ti ti-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="container">
                    <div  style="overflow-x: auto; max-width: 100% ">
                        <table id="activity-table" class="table table-striped table-bordered" style="width: 1350px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>@if($user?->phone) +237 @endif {{ $user?->phone }}</td>
                                    <td>{{$user?->role}}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}</td>
                                    <td class="d-flex align-items-center">
                                        <button  data-bs-toggle="modal"
                                                 data-bs-target="#updateGroupModal-{{ $user->id }}" class="btn p-0">
                                            <i class="ti ti-pencil text-primary"></i>
                                        </button>
                                        @if(auth()->user()->id != $user->id)
                                            <form action="{{ route('users_destroy', ['user' =>$user->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="me-1 p-0 btn">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                {{-- Modal for updating group--}}
                                <x-users.form
                                    id="updateGroupModal-{{ $user?->id }}"
                                    title="Update a Member"
                                    :action="'users_update'"
                                    type="update"
                                    :user="$user"
                                />
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries</div>
                        <div>{!! $users->appends(request()->input())->links("pagination::bootstrap-4") !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal pour ajouter un groupe --}}
    <x-users.form
        id="addGroupModal"
        title="Add a Member"
        :action="'users_store'"
        :type="'create'"
        :user="null"
    />


@endsection

@section('scripts')

@endsection
