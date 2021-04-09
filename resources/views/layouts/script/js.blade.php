<script src="{{ asset('app/assets/js/bundle.js') }}"></script>
<script src="{{ asset('app/assets/js/scripts.js') }}"></script>

@yield('custom_js')

<script>
    function deleteItem(url) {
        const answer = prompt("Are you sure? Type 'yes' to perform the operation!");
        if (answer === "yes") {
            //console.log('you said yes')
            window.location.href = url;
        }else{
            console.log('action ignored')
        }
    }
</script>