{{-- @if(isset(request()->sort) || isset(request()->cfilter))
    <a href="{{ url()->current() }}" class="bi-x-circle-fill" title="Clear Filters / Sorting"></a>
@endif --}}

<div class="btn-group dropleft">
    <A class="dropdown-toggle dropdown-toggle-dots" href="#" data-toggle="dropdown" ></A>
    <div class="dropdown-menu dropdown-menu-right shadow" style="">

        @if( count($gf = \AscentCreative\CMS\Models\SavedFilter::byUrl('/'.request()->path())->global()->get()) > 0)
        <div class="dropdown-item small text-small text-uppercase font-weight-bold">Global Filters</div>

            @foreach($gf as $f)
                <a href="{{ $f->url . '?' . $f->filter }}" class="dropdown-item text-sm bi-dot">{{ $f->name }}</a>
            @endforeach

        <div class="dropdown-divider"></div>
        @endif

        @if( count($pf = \AscentCreative\CMS\Models\SavedFilter::byUrl('/'.request()->path())->private()->get()) > 0)
        <div class="dropdown-item small text-small text-uppercase font-weight-bold">My Filters</div>
            
            @foreach($pf as $f)
                <a href="{{ $f->url . '?' . $f->filter }}" class="dropdown-item text-sm bi-dot">{{ $f->name }}</a>
            @endforeach

        <div class="dropdown-divider"></div>
        @endif
        


        <a href="{{ route('savefilters') }}" class="dropdown-item text-sm btn-delete modal-link">Save Filters</a>

        <div class="dropdown-divider"></div>

        <a href="{{ url()->current() }}" class="dropdown-item text-sm"> Clear Filters & Sorting</a>

    </div>
</div>