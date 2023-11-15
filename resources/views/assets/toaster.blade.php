<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
 @if(Session::has('toast-message'))
 var type = "{{ Session::get('toast-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('toast-message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('toast-message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('toast-message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('toast-message') }} ");
    break;
 }
 @endif
</script>
