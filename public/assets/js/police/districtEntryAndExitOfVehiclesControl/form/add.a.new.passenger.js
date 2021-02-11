$(document).ready(function () {
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var x = $('input[name*="surname"]').length; //Initial field counter is 1



    //Once add button is clicked
    $(addButton).click(function () {
        var fieldHTML =
            '<div class="field_wrapper_1 mt-4">' +
            '<i class="fas fa-user mr-1"></i>' +
            '<h7 class="my-1" id="numero_pasajero"><strong> Pasajero nº ' + (x + 1) + '</strong></h7><hr> ' +
            '<div class="form-group">\n' +
            '    <label>Nombre ( * ) :</label>\n' +
            '    <input type="text"\n' +
            '           placeholder=" - Obligatorio -"\n' +
            '           name="vehiclePassenger['+ x +'][name]"\n' +
            '           value=""\n' +
            '           maxlength="255"\n' +
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
            '           name="vehiclePassenger['+ x +'][surname]"\n' +
            '           value=""\n' +
            '           maxlength="255"\n' +
            '           class="form-control"\n' +
            '           required\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger">\n' +
            '    </small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Dni ( * ) :</label>\n' +
            '    <input type="number"\n' +
            '           placeholder=" - Obligatorio -"\n' +
            '           name="vehiclePassenger['+ x +'][identityCard]"\n' +
            '           value=""\n' +
            '           class="form-control"\n' +
            '           required\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Telefono :</label>\n' +
            '    <input type="text"\n' +
            '           placeholder=" - Opcional -"\n' +
            '           name="vehiclePassenger['+ x +'][phone]"\n' +
            '           value=""\n' +
            '           maxlength="255"\n' +
            '           class="form-control"\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Dirección :</label>\n' +
            '    <input type="text"\n' +
            '           placeholder=" - Opcional -"\n' +
            '           name="vehiclePassenger['+ x +'][address]"\n' +
            '           value=""\n' +
            '           maxlength="255"\n' +
            '           class="form-control"\n' +
            '           required\n' +
            '    >\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            '</div>\n' +
            '\n' +
            '<div class="form-group">\n' +
            '    <label>Temperatura ( * ) :</label>\n' +
            '    <input type="text"\n' +
            '           placeholder=" - Obligatorio -"\n' +
            '           name="vehiclePassenger['+ x +'][temperatureControl]"\n' +
            '           value=""\n' +
            '           maxlength="255"\n' +
            '           class="form-control"\n' +
            '           required="">\n' +
            '    <small class="errorLabelContainer form-text text-muted text-danger"></small>\n' +
            ' </div>' +
            '<a href="javascript:void(0);" class="remove_button btn btn-danger btn-border font-weight-bold"><i class="fas fa-user-times mr-1"></i> Quitar pasajero</a><hr></div>'; //New input field html

        addRules(x);

        //Check maximum number of input fields
        if (x < maxField) {
            $('#passengerCounter').html('Cantidad de pasajeros ( ' + (x + 1) + ' )');
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }

    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove();//Remove field html
        x--; //Decrement field counter
    });
});

function addRules(id){
    $("input[name='vehiclePassenger["+id+"][name]']").rules("add", {required: true});
    $("input[name='vehiclePassenger["+id+"][surname]']").rules("add", {required: true});
    $("input[name='vehiclePassenger["+id+"][identityCard]']").rules("add", {required: true});
    $("input[name='vehiclePassenger["+id+"][temperatureControl]']").rules("add", {required: true});

}

