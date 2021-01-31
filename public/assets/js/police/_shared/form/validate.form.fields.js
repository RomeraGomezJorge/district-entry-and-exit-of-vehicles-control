$(document).ready(function () {

    $("#form").validate({

        onfocusout: function (element) {
            /* validate a field on focus out*/
            $(element).valid();
        },
        onkeyup: false,
        submitHandler: function(){
            /*when an valid form is submitted. Disabled submit button and set the loading icon*/
            $("#submitBtn i").removeClass('fas fa-save');
            $("#submitBtn i").addClass('fas fa-sync-alt fa-spin fa-3x fa-fw');
            $("#submitBtn ").attr("disabled", true);
            form.submit();
        },
        invalidHandler: function(){
            /*when an invalid form is submitted. Enabled submit button and set the default icon*/
            $("#submitBtn i").removeClass('fas fa-sync-alt fa-spin fa-3x fa-fw');
            $("#submitBtn i").addClass(' fas fa-save');
            $("#submitBtn ").attr("disabled", false);

        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        }
    });

    $('#form input:visible:enabled:first').focus();




});