@extends('layouts.dashboard')

@section('title', 'Groups')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-utils.breadcrumb parent="Groups" />
                <div class="d-flex align-items-center justify-content-between my-4">
                    @if(auth()->user()->role == \App\Models\User::ADMIN)
                        <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                data-bs-target="#addGroupModal">
                            <i class="ti ti-plus"></i>
                            <span class="ms-2">Add a Group</span>
                        </button>
                    @endif
                    <form action="{{ route('groups.index') }}" method="GET" class="input-group w-25 d-flex justify-content-end">

                            <input type="text" class="form-control" name="search" placeholder="Search by name"
                                   value="{{ request()->input('search') }}">

                        <button class="btn btn-primary" type="submit">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                </div>
                <div class="row">
                    @foreach ($groups as $group)
                        <x-group-card
                            :class="'col-sm-6 col-md-3 col-xl-3 rounded-15 custom-class'"
                            :deleteRoute="'groups.destroy'"
                            :imageUrl="Storage::url($group->logo)"
                            :name="$group->name"
                            :group="$group ?? null"
                            :users="$users"
                        />
                    @endforeach

                </div>
                <div class="d-flex justify-content-center">
                    {!! $groups->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal pour ajouter un groupe --}}
    <x-group-form
        id="addGroupModal"
        title="Add a Group"
        :action="'groups.store'"
        :type="'create'"
        :group="null"
        :users="$users"
    />

@endsection

@section('scripts')

    <script>
        function previewImage(event) {
            var preview = document.getElementById('preview');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".live-search").chosen({
                width: '100%',
                search_contains: true
            });

            $(".chosen-choices").css({
                display: 'block',
                width: '100%',
                padding: '8px 16px',
                fontSize: '0.875rem',
                fontWeight: '400',
                lineHeight: '1.5',
                color: '#5A6A85',
                border: 'var(--bs-border-width) solid #DFE5EF',
                borderRadius: '7px',
                transition: 'border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out,box-shadow 0.15s ease-in-out'
            });
        });
    </script>
@endsection
