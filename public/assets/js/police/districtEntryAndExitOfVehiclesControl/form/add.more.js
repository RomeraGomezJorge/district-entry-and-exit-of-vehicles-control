$(document).ready(function () {
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var x = 1; //Initial field counter is 1


    //Once add button is clicked
    $(addButton).click(function () {
        var fieldHTML =
            '<div class="field_wrapper_1">' +
            "<h7 class='my-1' id='numero_pasajero'><strong> Pasajero nº " + (x + 1) + "</strong></h7><hr>" +
            '<div class="form-group"> <label class="form-control-label">Nombre * :</label> ' +
            '<input type="text" id="fname" name="fname[]" placeholder="" class="form-control"' +
            ' onblur="validate1(1)">' +
            ' </div>' +
            '<div class="form-group"> <label class="form-control-label">Apellido * :</label> ' +
            '<input type="text" id="lname" name="lname" placeholder="" class="form-control" onblur="validate1(2)"> </div>' +
            '<div class="form-group"> <label class="form-control-label">D.N.I * :</label>' +
            '<input type="text" id="email" name="email" placeholder="" class="form-control" onblur="validate1(3)"> </div>' +
            '<div class="form-group"> <label class="form-control-label">Temperatura. * :</label>' +
            '<input type="text" id="mob" name="mob" placeholder="" class="form-control" onblur="validate1(4)"> </div>' +
            '<a href="javascript:void(0);" class="remove_button btn btn-danger btn-border"><i class="fa fa-times-circle' +
            ' "></i>&nbsp;Quitar pasajero</a><hr></div>'; //New
        // input field html
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $('#contador').html('Cantidad de pasajeros ( ' + x + ' )');
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