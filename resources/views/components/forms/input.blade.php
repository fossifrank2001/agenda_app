@props(['id', 'label', 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false])

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control @error($id) is-invalid @enderror" id="{{ $id }}" name="{{ $id }}" value="{{ old($id, $value) }}" placeholder="{{ $placeholder }}" @if($required) required @endif>
    @error($id)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
