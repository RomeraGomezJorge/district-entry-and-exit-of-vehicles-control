$(document).ready(function () {
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('#new_passenger_container'); //Input field wrapper
    var passengerCounter = $('input[name*="surname"]').length; //Initial field counter is 1


    //Once add button is clicked
    $(addButton).on('click', function (e) {

        e.preventDefault();

        //Check maximum number of input fields
        if (passengerCounter == maxField) {
            return;
        }

        $('.passengerNumberTitle').each(function (index) {
            $(this).html('<strong> Pasajero nº ' + (index + 2) + '</strong')
        });

        $('.remove_button').each(function (index) {
            $(this).html('<strong>  Quitar pasajero n°' + (index + 2) + '</strong')
        });

        const newPassenger =
            '<div class="mt-4">' +
            '<i class="fas fa-user mr-1"></i>' +
            '<h7 class="my-1 passengerNumberTitle" ><strong> Pasajero nº ' + (passengerCounter + 1) + '</strong></h7><hr> ' +
            '<div class="form-group">\n' +
            '    <label>Nombre ( * ) :</label>\n' +
            '    <input type="text"\n' +
            '           placeholder=" - Obligatorio -"\n' +
            '           name="vehicle_passenger[' + passengerCounter + '][name]"\n' +
            '           value=""\n' +
            '           data-passenger_number="' + passengerCounter + '"' +
            '           maxlength="100"\n' +
            '           class="form-control"\n' +
            '           required\n' +
            '           autofocus\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger">\n' +
            '    </small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Apellido ( * ) :</label>\n' +
            '    <input type="text"\n' +
            '           placeholder=" - Obligatorio -"\n' +
            '           name="vehicle_passenger[' + passengerCounter + '][surname]"\n' +
            '           value=""\n' +
            '           data-passenger_number="' + passengerCounter + '"' +
            '           maxlength="100"\n' +
            '           class="form-control"\n' +
            '           required\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger">\n' +
            '    </small>\n' +
            '</div>\n' +
            '<div class="form-group">' +
            '   <div class="form-check">' +
            identityCardTypeHml(passengerCounter) +
            '   </div>' +
            '</div>' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Documento ( * ) :</label>\n' +
            '    <input type="number"\n' +
            '           placeholder=" - Obligatorio -"\n' +
            '           name="vehicle_passenger[' + passengerCounter + '][identityCard]"\n' +
            '           value=""\n' +
            '           minlength="6"' +
            '           data-passenger_number="' + passengerCounter + '"' +
            '           class="form-control"\n' +
            '           required\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Telefono :</label>\n' +
            '    <input type="number"\n' +
            '           placeholder=" - Opcional -"\n' +
            '           name="vehicle_passenger[' + passengerCounter + '][phone]"\n' +
            '           value=""\n' +
            '           data-passenger_number="' + passengerCounter + '"' +
            '           maxlength="100"\n' +
            '           class="form-control"\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Dirección :</label>\n' +
            '    <input type="text"\n' +
            '           placeholder=" - Opcional -"\n' +
            '           name="vehicle_passenger[' + passengerCounter + '][address]"\n' +
            '           value=""\n' +
            '           data-passenger_number="' + passengerCounter + '"' +
            '           maxlength="100"\n' +
            '           class="form-control"\n' +
            '           required\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Temperatura ( * ) :</label>\n' +
            '    <input type="number"\n' +
            '           placeholder=" - Obligatorio -"\n' +
            '           name="vehicle_passenger[' + passengerCounter + '][temperatureControl]"\n' +
            '           value=""\n' +
            '           data-passenger_number="' + passengerCounter + '"' +
            '           min="35.0"' +
            '           max="42.0"' +
            '           maxlength="4"' +
            '           class="form-control"\n' +
            '           required="">\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            ' </div>' +
            '<a href="javascript:void(0);" class="remove_button btn btn-danger btn-border font-weight-bold">' +
            '   <i class="fas fa-user-times mr-1"></i> ' +
            '   Quitar pasajero n°' + (passengerCounter + 1) +
            '</a>' +
            '<hr>' +
            '</div>'; //New input field html


        $('#passengerCounter').html('Cantidad de pasajeros ( ' + (passengerCounter + 1) + ' )');

        $(wrapper).append(newPassenger); //Add field html

        addRulesForTheNewPassenger(passengerCounter);

        passengerCounter++; //Increment field counter
    });

    //Once remove button is clicked
    $('body').on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent().remove();//Remove field html
        passengerCounter--; //Decrement field counter
        $('#passengerCounter').html('Cantidad de pasajeros ( ' + passengerCounter + ' )');

    });
});

function addRulesForTheNewPassenger(id) {
    $("input[name='vehicle_passenger[" + id + "][name]']").rules("add", {required: true});
    $("input[name='vehicle_passenger[" + id + "][surname]']").rules("add", {required: true});
    $("input[name='vehicle_passenger[" + id + "][identityCard]']").rules("add", {required: true});
    $("input[name='vehicle_passenger[" + id + "][temperatureControl]']").rules("add", {required: true});
    $("input[name='vehicle_passenger[" + id + "][identityCardTypeId]']").rules("add", {required: true});

}


function identityCardTypeHml(passengerCounter) {

    let identityCardTypeId = $('#identityCardTypeId').html();

    let incrementDataPassengerNumber = identityCardTypeId.replaceAll('data-passenger_number="' + passengerCounter + '"', 'data-passenger_number="' + passengerCounter + '"');

    const incrementPassengerIndex = incrementDataPassengerNumber.replaceAll('vehicle_passenger[0][identityCardTypeId]', 'vehicle_passenger[' + passengerCounter + '][identityCardTypeId]');

    return incrementPassengerIndex;
}