function disablingEnteKeyForForm() {
    $(document).keypress(
        function(event){
            if (event.which == '13') {
                event.preventDefault();
                $('button[type="submit"]').click();
            }
        });
}