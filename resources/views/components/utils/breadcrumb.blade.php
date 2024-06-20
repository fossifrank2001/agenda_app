@props(['parent', 'child', 'url'=>null])

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-2">
    <div class="card-body px-4 py-1" style="height: 75px;">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $parent }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        @if(isset($url))
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route($url) }}">{{ $parent }}</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">{{ $child }}</li>
                        @else
                            <li class="breadcrumb-item" aria-current="page">{{ $parent }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('assets/images/backgrounds/ChatBc.png') }}" alt="modernize-img"
                         class="img-fluid mb-n4" />
                </div>
            </div>
        </div>
    </div>
</div>
