<a href="{{ url()->current() }}" id="btn-select-toggle" class="bi-ui-checks text-dark" style="font-size: 1.2rem; line-height: 1em;" title="Check / Uncheck All"></a>

@push('scripts')

<script>

    $('A#btn-select-toggle').click(function(e) {
        e.preventDefault();
       
        if ( $('INPUT.item-select').not(':checked').length == 0 ) {
            // uncheck all
             $('tr.item-row').each(function() {
                deselectRow($(this));
             })
            // $('INPUT.item-select').prop('checked', false);
            // $('A#btn-select-toggle').removeClass('text-primary').addClass('text-dark');
        } else {
            // check all
            // $('INPUT.item-select').prop('checked', true);
            $('tr.item-row').each(function() {
                selectRow($(this));
             })
            // $('A#btn-select-toggle').removeClass('text-dark').addClass('text-primary');
        }

    });

</script>

@endpush
