@if(isset(request()->sort) || isset(request()->cfilter))
    <a href="{{ url()->current() }}" class="bi-x-circle-fill" title="Clear Filters / Sorting"></a>
@endif

<div class="btn-group dropleft">
    <A class="dropdown-toggle dropdown-toggle-dots" href="#" data-toggle="dropdown" ></A>
    <div class="dropdown-menu dropdown-menu-right" style="">

        <a href="{{ url()->current() }}" class="dropdown-item text-sm bi-x-circle-fill"> Clear Filters & Sorting</a>

    </div>
</div>