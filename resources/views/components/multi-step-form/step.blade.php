@aware(['idx'=>-1])

@push(\view()->shared('progress'))
    <li class="{{ $icon }}" id="progress-{{ Str::slug($label) }}">
        <span class="d-none d-sm-inline">
        {{-- <A href="#" wire:click="$set('current_step', '{{ $id }}')"> --}} {{ $label }} {{-- </a> --}}
        </span>
    </li>
@endpush



<div class="msf-step" id="msf-step-{{ Str::slug($label) }}" data-stepslug="{{ Str::slug($label) }}" data-validators="{{
    Crypt::encryptString(json_encode(['validators'=>$validators, 'messages'=>$validatormessages]));        
}}">

  

    {{ $slot }}

    @if($showButtons)
    <div class="msf-nav">

        <div class="m-2 m-sm-5  flex flex-between">

            {{-- Don't show this button on the first tab  --}}
            {{-- @if($idxStep != 0) --}}
                <div>
                    @if($showBackButton)
                    <button class="btn btn-secondary prevBtn xpull-right msf-back {{ $backIcon }}" 
                    type="button"> {{ $backLabel }}</button>
                    @endif
                </div>
            {{-- @endif --}}

                <div>
                    @if($showContinueButton)
                    <button class="btn btn-primary nextBtn pull-right msf-continue {{ $continueIcon }}" 
                    type="button"> {{ $continueLabel }}</button>
                    @endif
                </div>

            {{-- Maybe the last step should have a different label? --}}

        </div>

    </div>
    @endif

</div>