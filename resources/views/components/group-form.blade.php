@props(['id' => '', 'title' => '', 'action'=>'', 'type'=>'', 'group', 'users'])

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
                    action="{{ $group ? route('groups.update', ['group' => $group->id]) : route('groups.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if($group)
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif

                    <!-- Hidden input to identify the form -->
                    <input type="hidden" name="form_id" value="{{ $id }}">

                    <x-forms.input id="name" label="Name*" name="name" placeholder="Enter your name" :required="true" :value="old('name', $group ? $group->name : '')" />
                    <x-forms.textarea id="description" label="Description" name="description" placeholder="Enter group description"  :value="old('description', $group ? $group->description : '')" rows="5" />

                    <x-forms.multiselect-input
                        id="users"
                        name="users"
                        label="Add a member/members"
                        :options="$users?->pluck('name', 'id')->toArray() ?? []"
                        :selected="$group ? $group->users->pluck('id')->toArray() : []"
                    />

                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/png,image/jpg,image/jpeg" onchange="previewImage(event, '{{ $id }}')">
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <img id="preview-{{ $id }}" src="{{ old('logo') ? Storage::url(old('logo')) : ($group && $group->logo ? Storage::url($group->logo) : '#') }}" alt="Preview" style="max-width: 100%; height: auto; {{ old('logo') || ($group && $group->logo) ? 'display: block;' : 'display: none;' }}">
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

@section('scripts')
    @parent
    <script>
        function previewImage(event, id) {
            var preview = document.getElementById(`preview-${id}`);
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

        $(document).ready(function() {
            $(".chosen-select").chosen({
                width: '100%',
                search_contains: true
            });
        });
    </script>
@endsection
