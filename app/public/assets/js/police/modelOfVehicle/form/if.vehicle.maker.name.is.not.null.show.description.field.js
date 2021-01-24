$(document).ready(function () {
    const vehicleMakerName_id = $('select[name="vehicleMakerName_id"]');

    const description_container = $('#description_container');

    if (vehicleMakerName_id.val() !== null) {
        description_container.removeClass('d-none');
    }

    vehicleMakerName_id.on('change', function () {
        if ($(this).val() !== null) {
            description_container.removeClass('d-none');
        }
    })

    vehicleMakerName_id.focus();
})