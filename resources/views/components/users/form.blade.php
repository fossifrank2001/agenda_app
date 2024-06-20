@props(['id' => '', 'title' => '', 'action'=>'', 'type'=>'', 'user'])

<div class="modal fade @if ($errors->any() && old('form_id') == $id) show @endif" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true" style="@if ($errors->any() && old('form_id') == $id) display: block; @endif">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any() && old('form_id') == $id)
                    <div class="mt-3">
                        @foreach ($errors->all() as $error)
                            <x-utils.alert type="danger" :message="$error" />
                        @endforeach
                    </div>
                @endif
                <form
                    action="{{ $user ? route('users_update', ['user' => $user->id]) : route('users_store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if($user)
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif

                    <!-- Hidden input to identify the form -->
                    <input type="hidden" name="form_id" value="{{ $id }}">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <x-forms.input id="name" label="Name*" name="name" placeholder="Enter your name" :required="true" :value="old('name', $user ? $user->name : '')" />
                        </div>
                        <div class="col-xs-12 @if($type == 'update') col-md-6 @else col-md-12 @endif">
                            <x-forms.input id="email" type="email" label="Email address" name="email" placeholder=""  :value="old('email', $user ? $user->email : '')" />
                        </div>
                        <div class="col-xs-12 @if($type == 'update') col-md-6 @else col-md-12 @endif">
                            <x-forms.input id="phone" label="Phone" name="phone" placeholder="" :value="old('phone', $user ? $user->phone : '')" />
                        </div>
                        @if($type == 'update')
                            <div class="col-xs-12 col-md-12">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" class="form-select mr-sm-2 mb-2">
                                    <option value="">Select Group</option>
                                    @foreach([\App\Models\User::ADMIN, \App\Models\User::MEMBER] as $role)
                                        <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

