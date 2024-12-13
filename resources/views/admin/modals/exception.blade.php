<x-cms-modal modlaId="ajaxModal" size="sm" :centered="true">

    <x-slot name="title">An Unexpected Error Occurred</x-slot>

    <div style="display: grid; gap: 1rem">
   
        <div>An error occurred while performing this action.</div>

        <div class="alert alert-warning">
            {{ $exception->getMessage() }}
        </div>

    </div>


    <x-slot name="footer">
        <button class="btn btn-primary" data-dismiss="modal">OK</button>
    </x-slot>

</x-cms-modal>

<script>

    $(document).on('hide.bs.modal', function() {
        window.location.reload();
    }); 

</script>