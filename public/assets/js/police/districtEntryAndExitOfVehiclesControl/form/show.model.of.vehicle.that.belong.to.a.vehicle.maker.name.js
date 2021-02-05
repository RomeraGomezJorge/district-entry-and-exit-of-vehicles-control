$(document).ready(function () {

    const vehicleMakerNameIdSelect = $('select[name="vehicleMakerNameId"]');

    const modelOfVehicleIdSelect = $('select[name="modelOfVehicleId"]');

    /* si el valor por que tiene del select que tiene la marcas de los vehiculos es distinto de null
    muestra los modelos que pertenecen a la marca seleccionada y ocultara el resto */
    if (vehicleMakerNameIdSelect.val() !== null) {
        modelOfVehicleIdSelect.removeClass('d-none');

        const vehicleMakerNameChosen = vehicleMakerNameIdSelect.val();

        $('select[name="modelOfVehicleId"] option').hide();

        $('select[name="modelOfVehicleId"] option[data-vehicle_maker_name_id="' + vehicleMakerNameChosen + '"]').show();
    }

    /*Al cambiar el valor de las marcas de los vehiculos muestra el select que tiene los modelos correspondiente
    a esa marca y ocultara el resto*/
    vehicleMakerNameIdSelect.on('change', function () {

        /* limpia la seleccion previa*/
        modelOfVehicleIdSelect.val(null);

        /*obtiene el id de la marca selecionada */
        const vehicleMakerNameChosen = vehicleMakerNameIdSelect.val();

        /* oculta todos */
        $('select[name="modelOfVehicleId"] option').hide();

        /* solo muestra los modelo que pertenezcan a la marca seleccionada */
        $('select[name="modelOfVehicleId"] option[data-vehicle_maker_name_id="' + vehicleMakerNameChosen + '"]').show();
    });
});
