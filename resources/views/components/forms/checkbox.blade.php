@props(['id', 'label', 'checked' => false])

<div class="form-check">
    <input class="form-check-input primary" type="checkbox" id="{{ $id }}" name="{{ $id }}" @if($checked) checked @endif>
    <label class="form-check-label text-dark" for="{{ $id }}">{{ $label }}</label>
</div>
