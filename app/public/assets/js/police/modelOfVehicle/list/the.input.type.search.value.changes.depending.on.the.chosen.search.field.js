$(document).ready(function () {

    const filter_field = $('select[name="filters[0][field]"]');
    const vehicleMakersName = $('#valuesOfVehicleMakersName');
    const valuesNotEqualToRole = $('#valuesNotEqualVehicleMakersName');

    filter_field.on('change', function () {

        /* en caso que el campo de busqueda sea "marca de vehiculos" muestra la etiqueta select
        que contiene todas mas las marcas de vehiculos y oculta el campo que permite ingresar caracteres */
        if (filter_field.val() === 'vehicleMakerName') {

            vehicleMakersName.attr('name', 'filters[0][value]')
            vehicleMakersName.removeClass('d-none');

            $('#notEqualTo').hide();

            valuesNotEqualToRole.addClass('d-none');
            valuesNotEqualToRole.removeAttr('name');
            return false;
        }

        /* en caso que el campo de busqueda sea distinto "marca de vehiculos" oculta la etiqueta select
        que contiene todas mas las marcas de vehiculos y muersta el campo que permite ingresar caracteres */
        valuesNotEqualToRole.removeClass('d-none');
        valuesNotEqualToRole.attr('name', 'filters[0][value]')

        $('#notEqualTo').hide();

        vehicleMakersName.addClass('d-none');
        vehicleMakersName.removeAttr('name');

        return false;
    })
})