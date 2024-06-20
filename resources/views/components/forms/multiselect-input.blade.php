@props(['id' => '', 'name' => '', 'label' => '', 'options' => [], 'selected' => []])

@php
    // Convertir les valeurs sélectionnées en tableau d'ID pour la comparaison
    $selectedIds = collect($selected)->map(function($item) {
        return (string) $item;
    })->toArray();
@endphp

<div>
    <label for="{{ $id }}">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}[]" class="live-search w-100 chosen-select" multiple>
        <option></option>
        @foreach ($options as $value => $option)
            <option value="{{ $value }}" @if(in_array((string) $value, $selectedIds)) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
    @error($name)
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $("#{{ $id }}").chosen({
                width: '100%',
                search_contains: true
            });
        });
    </script>
@endsection
