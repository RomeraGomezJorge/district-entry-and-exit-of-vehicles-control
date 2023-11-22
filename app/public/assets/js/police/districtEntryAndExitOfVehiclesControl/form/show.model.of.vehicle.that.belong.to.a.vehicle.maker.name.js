$(document).ready(function () {

    const vehicle_maker_name_idSelect = $('select[name="vehicle_maker_name_id"]');

    const modelOfVehicleIdSelect = $('select[name="model_of_vehicle_id"]');

    const modelOfVehicleContainer = $("#modelOfVehicleIdContainer");


    /* si el valor que tiene del select de la marcas de los vehiculos es distinto de null
    muestra los modelos que pertenecen a la marca seleccionada y ocultara el resto */
    if (vehicle_maker_name_idSelect.val() !== null) {

        const vehicleMakerNameChosen = vehicle_maker_name_idSelect.val();

        /* muestra el select con los modelos de vehiculos */
        modelOfVehicleContainer.removeClass('d-none');

        /* oculta todos los modelos de vehiculos */
        $('select[name="model_of_vehicle_id"] option').hide();

        /* muestra solo los modelos que pertenecen al id de la marca de vehiculos seleccinada */
        $('select[name="modelOfVehicleId"] option[data-vehicle_maker_name_id="' + vehicleMakerNameChosen + '"]').show();
    }


    /*Al cambiar el valor de las marcas de los vehiculos muestra el select que tiene los modelos correspondiente
    a esa marca y ocultara el resto*/
    vehicle_maker_name_idSelect.on('change', function () {

        showModelOfVehicleIfVehicleMakerNameIsNotNull(vehicle_maker_name_idSelect, modelOfVehicleContainer);

        /* limpia la seleccion previa*/
        modelOfVehicleIdSelect.val(null);

        /*obtiene el id de la marca selecionada */
        const vehicleMakerNameChosen = vehicle_maker_name_idSelect.val();

        /* oculta todos */
        $('select[name="model_of_vehicle_id"] option').hide();

        /* solo muestra los modelo que pertenezcan a la marca seleccionada */
        $('select[name="model_of_vehicle_id"] option[data-vehicle_maker_name_id="' + vehicleMakerNameChosen + '"]').show();
    });
});

/* Muesta el select de los modelos de los vehiculos solo si la marca de vehiculos seleccinada no sea nulo*/
function showModelOfVehicleIfVehicleMakerNameIsNotNull(vehicle_maker_name_idSelect, modelOfVehicleContainer) {

    if (vehicle_maker_name_idSelect.val() !== null) {
        modelOfVehicleContainer.removeClass('d-none');
        return;
    }

    modelOfVehicleContainer.addClass('d-none');
}
