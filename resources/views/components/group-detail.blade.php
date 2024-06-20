
@props(['id' => '', 'group'])

<div class="modal fade" id="{{$id}}-{{ $group->id }}" tabindex="-1" aria-labelledby="groupDetailsModalLabel-{{ $group->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="groupDetailsModalLabel-{{ $group->id }}">Group Details: {{ $group->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <img src="{{ Storage::url($group->logo) }}" class="img-fluid rounded" alt="{{ $group->name }}">
                    </div>
                    <div class="col-xs-12 col-md-8">
                        <p><strong>Name:</strong> {{ $group->name }}</p>
                        <p><strong>Description:</strong> {{ $group->description ?: 'N/A' }}</p>
                        <p><strong>Number of Users:</strong> {{ $group->users->count() ?: 'N/A' }}</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
