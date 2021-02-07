function validateVehicleInfo() {

    const validator = $("#form").validate();

    const flagVehicleMakerNameId = validator.element("#vehicleMakerNameId");

    const flagModelsOfVehicleId = validator.element("#modelOfVehicleId");

    /* se usa este selector "input[name='vehicleBodyTypeId']" ya que el input es de tipo "option" */
    const flagVehicleBodyTypeId = validator.element("input[name='vehicleBodyTypeId']");

    return flagVehicleBodyTypeId && flagVehicleMakerNameId && flagModelsOfVehicleId;
}

function validateTripInfo() {

    const validator = $("#form").validate();

    const flagTripOriginId = validator.element("#tripOriginId");

    const flagTripDestinationId = validator.element("#tripDestinationId");

    /* se usa este selector "input[name='reasonForTripId']" ya que el input es de tipo "option" */
    const flagReasonForTripId = validator.element("input[name='reasonForTripId']");

    return flagTripOriginId && flagTripDestinationId && flagReasonForTripId;
}

$(document).ready(function () {

    var currentFieldSet, nextFieldSet, previous_fs;

    $(".next").click(function () {

        $(window).scrollTop(0);

        const passengerValidations = "passengerValidations";

        const vehicleValidations = "vehicleValidations";

        const tripValidations = "tripValidations";

        const val2 = !vehicleValidations.localeCompare($(this).attr('id')) && validateVehicleInfo() === true;

        const val3 = !tripValidations.localeCompare($(this).attr('id')) && validateTripInfo() === true;

        if (
            !passengerValidations.localeCompare($(this).attr('id')) ||
            (!vehicleValidations.localeCompare($(this).attr('id')) && val2 === true) ||
            (!tripValidations.localeCompare($(this).attr('id')) && val3 === true)) {

            currentFieldSet = $(this).parent().parent();
            nextFieldSet = $(this).parent().parent().next();

            $(currentFieldSet).removeClass("show");
            $(nextFieldSet).addClass("show");

            $(nextFieldSet).find('input:visible:first').focus();
        }
    });

    $(".prev").click(function () {

        $(window).scrollTop(0);

        currentFieldSet = $(this).parent().parent();
        previous_fs = $(this).parent().parent().prev();

        $(currentFieldSet).removeClass("show");
        $(previous_fs).addClass("show");

    });


});