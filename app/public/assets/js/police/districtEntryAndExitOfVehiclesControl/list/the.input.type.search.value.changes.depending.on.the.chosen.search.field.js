$(document).ready(function () {

    $("body").on('change', ".filter-field", function () {

        const filterValue = $(this).parent().parent().find('.filter-value');
        const filterOperator = $(this).parent().parent().find('.filter-operator');

        if ($(this).val() !== 'createAt') {

            /* quita la mascara de tipo fecha */
            filterValue.inputmask("remove");

            showFieldsToSearchText(filterOperator);

            return false;
        }

        showFieldsToSearchDates(filterOperator);

        setAMaskDateInInputSearchValue(filterValue);

    });

    $(".filter-field").prop("selectedIndex", 0).change();
})

/*  muestra solo los campos para buscar textos */
function showFieldsToSearchText(filterOperator) {
    filterOperator.val('=');
    filterOperator.children('option').show();
    filterOperator.children('option[value="<"],option[value=">"]').hide();
}

/* muestra los solo campos para buscar fechas */
function showFieldsToSearchDates(filterOperator) {
    filterOperator.val('>');
    filterOperator.children('option').show();
    filterOperator.children('option[value="CONTAINS"],option[value="="]').hide();
}

/* agrega  una la mascara para q se cargues solo datos tipo fecha  */
function setAMaskDateInInputSearchValue(filterValue) {
    filterValue.inputmask("datetime", {
        "placeholder": "dd/mm/yyyy hh:mm:ss",
        "inputFormat": "dd-mm-yyyy hh:mm:ss"
    });
}