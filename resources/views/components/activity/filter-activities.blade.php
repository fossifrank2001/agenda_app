@props(['groups', 'currentFilters'])

<form action="{{ route('activities') }}" method="GET" class="form d-flex align-items-center row">
    <div class="col-xs-12 col-md-6">
        <div class="mb-2">
            <label for="group_id">Select Group</label>
            <select id="group_id" name="group_id" class="form-select">
                <option value="">Select Group</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" @if($currentFilters['group_id'] == $group->id) selected @endif>{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-md-3">
        <label for="start_time" class="form-label">Start Time</label>
        <input type="text" id="start_time"  class="form-control datetimepicker-input" data-target="#start_time" name="start_date" value="{{ $currentFilters['start_date'] }}"/>
    </div>
    <div class="col-xs-12 col-md-3">
        <label for="end_time" class="form-label">End Time</label>
        <input type="text" id="end_time"  class="form-control datetimepicker-input" data-target="#end_time" name="end_date" value="{{ $currentFilters['end_date']}}"/>
    </div>
    <div class="col-xs-12 col-md-3">
        <x-forms.input id="search" label="Search:" type="text" placeholder="Search..." :value="$currentFilters['search']" />
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="btn-group mt-1" role="group" aria-label="Basic example">
            <button class="btn btn-primary" type="submit">
                <i class="ti ti-search"></i> Search
            </button>
            <button type="button" class="btn btn-dark" onclick="resetFilters()">
                <i class="ti ti-refresh"></i> Reset
            </button>
        </div>
    </div>
</form>

@section('scripts')
    @parent
    <script>
        function resetFilters(){
            window.location.href="{{route("activities")}}"
        }
    </script>
@endsection
