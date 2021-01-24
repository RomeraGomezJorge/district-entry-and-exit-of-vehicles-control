$(document).ready(function () {

    const inputSelector = $('input[name="description"]');

    /* disablingEnteKeyForForm() FIX: prevent an exception, because if is enabled can submit the data without validate is a description is  already in use */
    disablingEnteKeyForForm();

    $('input[name="description"]').on('focusout',function () {
        addUniqueDescriptionRule(inputSelector);
    });

});


function addUniqueDescriptionRule(inputSelector) {

    const url_action = inputSelector.data('available_description_url');

    const description_from_database = inputSelector.data('description_from_database');

    if (description_from_database == inputSelector.val()) {
        inputSelector.rules("remove", "remote");
        return ;
    }

    inputSelector.rules("add", {
        messages: {remote: "La descripción que ha ingresado ya está registrada."},
        remote: {
            async: false,
            url: url_action,
            type: "GET",
            data: {
                'description': function () {
                    return inputSelector.val();
                }
            },
            dataType: 'json',
            complete: function (data) {
                const isAvailable = data.responseText;

                if (isAvailable === 'true') {
                    inputSelector.closest('.form-group').removeClass('has-error').addClass('has-success');

                    $('#form').submit();

                } else {
                    inputSelector.closest('.form-group').removeClass('has-success').addClass('has-error');
                    $.validator.messages.description = 'asdf';

                }
            }, error: function () {
                alert('erro');
            }
        }

    });
}



