@push('scripts')
    {{-- Load the cookie manager code --}}
    @script('/vendor/ascent/cms/jquery/jquery.cookie.js')
    @script('/vendor/ascent/cms/jquery/ascent.cms.cookiemanager.js')
@endpush

@php 

    $match = true; // whether the list of set cookies (regardless of value) matches the list - detects changes to site cookie config/types
    $count = 0; // counts the number of set cookies. 0 = new visitor, >0 = existing visitor with cookies set

@endphp

@foreach(\AscentCreative\CMS\Models\CookieType::all() as $cType)
    {{-- for each cookie type, load the templates --}}
    @includeIf('cookiemanager.' . $cType->slug, ['cType'=>$cType])

    {{-- for each cookie type, check whether set or not --}}
    @php
        
        if(isset($_COOKIE['acm_' . $cType->slug])) {
            $count++;
        } else {
            $match = false;
        }

    @endphp
@endforeach


{{-- footer bar --}}


@if(!$match)
<DIV id="acm_wrap">
    <DIV id="acm_prompt" class="centered">
        {{-- <div class="centered flex flex-between flex-align-top"> --}}
            <DIV id="acm_summary">
                <DIV id="acm_message">
                    <H4>Cookie Preferences</H4>
                    <div>
                        @if($count == 0) 
                            We use cookies on this site, and we need to know you're happy with that.
                        @else
                            Our cookies have changed - please review your settings.
                        @endif
                    </div>
                 </DIV> 
            </DIV>
            <div id="acm_action" class="text-center">
                <div><A class="button btn btn-primary nochevron acm_acceptall">Accept All Cookies</A></div>
                <div class="text-small text-white pt-2"><A id="acm_chooser" class="acm_manage" href="#" data-toggle="modal" data-target="#acm_modal">Let me choose</A></div>
            </div>
        {{-- </DIV> --}}
    </DIV>
</DIV> 
@endif

{{-- @dump($_COOKIE) --}}


{{-- cookie manager modal --}}
<div class="modal fade" id="acm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false"
>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cookie Settings</h5>
    
        </div>
        <div class="modal-body">


            @foreach(\AscentCreative\CMS\Models\CookieType::all() as $cType)

                <div class="acm_cookietype @if($cType->mandatory) acm_mandatory @endif  @if(isset($_COOKIE['acm_' . $cType->slug]) && $_COOKIE['acm_' . $cType->slug]==1) acm_selected @endif  " id="acm_{{ $cType->slug }}" data-cookie="acm_{{ $cType->slug }}">
                    <div class="acm_ct_title">
                        <div>
                            <label>{{ $cType->title }}</label>
                        </div>
                    </div>
                    <div class="acm_ct_status">
                        <div class="acm_status_badge"></div>
                    </div>
                    <div class="acm_ct_desc">
                        {{ $cType->description }}
                    </div>
                </div>

            @endforeach


        </div>
        <div class="modal-footer flex flex-between">
        
          <button type="button" class="btn btn-secondary acm_acceptselected">Accept Selected</button>
          <button type="button" class="btn btn-primary acm_acceptall">Accept All</button>
          
        </div>
      </div>
    </div>
  </div>