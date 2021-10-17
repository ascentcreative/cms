<div class="prog">PROG VAL</div>


@script('/vendor/ascent/cms/js/jquery-3.5.1.min.js')
        @script('/vendor/ascent/cms/js/jquery-ui.min.js')
<SCRIPT>

    window.setInterval(() => {
        $.get('/longrunprogress').done(function(data) { 
            $('.prog').html(data);
         });
    }, 500);

</SCRIPT>



