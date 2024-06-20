@props(['id', 'label', 'value' => '', 'placeholder' => '', 'rows' => 3])

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control" id="{{ $id }}" name="{{ $id }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
</div>
