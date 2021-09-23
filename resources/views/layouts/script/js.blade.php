<script src="{{ asset('app/assets/js/bundle.js') }}"></script>
<script src="{{ asset('app/assets/js/scripts.js') }}"></script>

@yield('vendor_js')

<script>
    function deleteItem(url, msg=null) {
        if(msg===null){
            msg = "Are you sure? Type 'yes' to perform the operation!";
        }
        const answer = prompt(msg);
        if (answer === "yes") {
            //console.log('you said yes')
            window.location.href = url;
        }else{
            console.log('action ignored')
        }
    }
</script>

@yield('custom_js')