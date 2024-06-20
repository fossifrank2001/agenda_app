@props(['class' => '',  'deleteRoute' => '', 'imageUrl', 'name', 'group', 'users'])

<div class="{{ $class }}">
    <div class="card border border-1 group overflow-hidden rounded-2">
        <div class="position-relative my-1 mx-auto d-flex">
            @if($imageUrl &&  $imageUrl != '/storage/')
                <a href="#" style="width: 90%;
                      margin: auto;">
                    <img src="{{ $imageUrl }}" class="card-img-top rounded-0"
                         style="
                      height: 75px;
                      border-radius: 12px!important;"
                         alt="{{ $name }}"
                    >
                </a>
            @endif
        </div>
        <div class="card-body pt-3 p-4">
            <h6 class="fw-semibold fs-4 text-center">{{ $name }}</h6>
            @if(auth()->user()->role == \App\Models\User::ADMIN)
                <div class="d-flex align-items-center justify-content-center">
                    <ul class="list-unstyled d-flex align-items-center mb-0">
                        <li>
                            <a href="#" class="me-1 btn btn-light btn-circle" data-bs-toggle="modal" data-bs-target="#groupDetailsModal-{{ $group->id }}">
                                <i class="ti ti-eye text-dark"></i>
                            </a>
                        </li>
                        <li class="mx-2">
                            <button  data-bs-toggle="modal"
                                     data-bs-target="#updateGroupModal-{{ $group->id }}" class="me-1 btn btn-light btn-circle">
                                <i class="ti ti-pencil text-primary"></i>
                            </button>
                        </li>
                        <li>
                            <form action="{{ route($deleteRoute, ['group' => $group->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="me-1 btn btn-danger btn-circle">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal for updating group--}}
<x-group-form
    id="updateGroupModal-{{ $group->id }}"
    title="Update a Group"
    :action="'groups.update'"
    type="update"
    :group="$group"
    :users="$users"
    :selectedUsers="$group?->users?->pluck('id')?->toArray()"
/>


<!-- Modal for detail -->
<x-group-detail
    id="groupDetailsModal"
    :group="$group"
/>
