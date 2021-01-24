function changeTheDefaultBehaviorOfTheEnterKey() {
    $(document).keypress(
        function(event){
            if (event.which == '13') {
                $('button[type="submit"]').focus();
                event.preventDefault();
                $('button[type="submit"]').click();
            }
        });
}