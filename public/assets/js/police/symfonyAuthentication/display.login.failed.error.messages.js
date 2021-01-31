$(document).ready(
    function () {
        var placementFrom = $('#notify_placement_from option:selected').val();
        var placementAlign = $('#notify_placement_align option:selected').val();
        var content = {};

        content.message = 'El usuario o la contraseña ingresadas no son validadas.';
        content.title = 'Credenciales no válidas.';
        content.icon = 'fas fa-exclamation';

        var notify = $.notify(content,{
            type: 'danger',
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            time: 1000,
            delay: 18000 ,
        });
    }
)