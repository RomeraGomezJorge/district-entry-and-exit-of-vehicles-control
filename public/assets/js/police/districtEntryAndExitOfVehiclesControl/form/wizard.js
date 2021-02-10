$(document).ready(function () {

    var currentFieldSet, previous_fs;

    $("#goToVehicleDetails").on('click', function () {

        $(window).scrollTop(0);

        if (!validateVPassengersInfo()) {
            return false;
        }
        goToNextStep(this);
    });


    $("#goToTripDetails").on('click', function () {

        $(window).scrollTop(0);

        if (!validateTripInfo()) {
            return false;
        }
        goToNextStep(this);
    });


    $(".prev").click(function () {
        $(window).scrollTop(0);
        currentFieldSet = $(this).parent().parent();
        previous_fs = $(this).parent().parent().prev();
        $(currentFieldSet).removeClass("show");
        $(previous_fs).addClass("show");

    });
});

function goToNextStep(selector) {

    const currentFieldSet = $(selector).parent().parent();
    const nextFieldSet = $(selector).parent().parent().next();

    $(currentFieldSet).removeClass("show");

    $(nextFieldSet).addClass("show");

    $(nextFieldSet).find('input:visible:first').focus();
}

/* comprueba que todos los campos de los pasajeros sean validos */
function validateVPassengersInfo() {

    const validator = $("#form").validate();

    let areThePassengerFieldsValid = true;

    $('input[name*="surname"]').each(function (index) {

        /* en caso que el falte el nombre en algun pasajero los datos de los pasajeros se marcan como invalidos */
        if (!validator.element("input[name='vehiclePassenger[" + index + "][name]']")) {
            areThePassengerFieldsValid = false;
        }

        /* en caso que el falte el apellido en algun pasajero los datos de los pasajeros se marcan como invalidos */
        if (!validator.element("input[name='vehiclePassenger[" + index + "][surname]']")) {
            areThePassengerFieldsValid = false;
        }

        /* en caso que el falte el documento en algun pasajero los datos de los pasajeros se marcan como invalidos */
        if (!validator.element("input[name='vehiclePassenger[" + index + "][identityCard]']")) {
            areThePassengerFieldsValid = false;
        }

        /* en caso que el falte la temperatura de algun pasajero los datos de los pasajeros se marcan como invalidos */
        if (!validator.element("input[name='vehiclePassenger[" + index + "][temperatureControl]']")) {
            areThePassengerFieldsValid = false;
        }

    });

    return areThePassengerFieldsValid;
}

/* comprueba que todos los campos del vehiculo sean validos */
function validateVehicleInfo() {

    const validator = $("#form").validate();

    const isFieldVehicleMakerNameIdValid = validator.element("#vehicleMakerNameId");

    const isFieldModelOfVehicleIdValid = validator.element("#modelOfVehicleId");

    /* se usa este selector "input[name='vehicleBodyTypeId']" ya que el input es de tipo "option" */
    const isFieldVehicleBodyTypeIdValid = validator.element("input[name='reasonForTripId']");

    return isFieldVehicleBodyTypeIdValid && isFieldVehicleMakerNameIdValid && isFieldModelOfVehicleIdValid;
}

/* comprueba que todos los campos sobre el viaje sean validos */
function validateTripInfo() {

    const validator = $("#form").validate();

    const flagTripOriginId = validator.element("#tripOriginId");

    const flagTripDestinationId = validator.element("#tripDestinationId");

    /* se usa este selector "input[name='reasonForTripId']" ya que el input es de tipo "option" */
    const flagReasonForTripId = validator.element("input[name='reasonForTripId']");

    return flagTripOriginId && flagTripDestinationId && flagReasonForTripId;
}