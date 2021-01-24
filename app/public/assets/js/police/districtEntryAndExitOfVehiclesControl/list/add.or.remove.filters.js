function addFilter(e) {
    e.preventDefault();
    const filterRows = document.getElementById('filter-rows');
    const totalRows = document.getElementById('filter-rows').childElementCount + 1;
    const filterRowTemplate = "<div class=\"filter-row form-inline\">\n" +
        "    <div class=\"form-group col-12 col-sm-4\">\n" +
        "        <select name=\"filters[" + totalRows + "][field]\"  class=\"filter-field form-control form-control-sm w-100\">\n" +
        "            <option value=\"createAt\" selected>Fecha del control</option>\n" +
        "            <option value=\"licensePlate\" selected>Dominio</option>\n" +
        "            <option value=\"name\" selected>Nombre de pasajero</option>\n" +
        "            <option value=\"surname\" selected>Apellido de pasajero</option>\n" +
        "            <option value=\"identityCard\" selected>Documento</option>\n" +
        "        </select>\n" +
        "    </div>\n" +
        "    <div class=\"form-group col-12 col-sm-4\">\n" +
        "        <select name=\"filters[" + totalRows + "][operator]\"  class=\"filter-operator form-control  form-control-sm w-100\">\n" +
        "            <option value=\"=\">es exactamente igual a</option>\n" +
        "            <option value=\"CONTAINS\">contiene</option>\n" +
        "            <option value=\">\">es mayor que</option>\n" +
        "            <option value=\"<\">es menor que</option>" +
        "        </select>\n" +
        "    </div>\n" +
        "    <div class=\"form-group col-12 col-sm-4\">\n" +
        "        <input name=\"filters[" + totalRows + "][value]\" type=\"text\" class=\"filter-value form-control form-control-sm w-100\" placeholder=\"Valor..\">\n" +
        "    </div>" +
        "   <div class=\"clearfix\"></div>" +
        "   <button type=\"button\" onclick=\"return this.parentNode.remove();\" class=\"remove_button btn btn-danger btn-border ml-2 mb-3\">" +
        "      <i class=\"fas fa-times-circle\"></i>  " +
        "      Quitar filtro " +
        "   </button>";
    "</div>";
    filterRows.insertAdjacentHTML('beforeend', filterRowTemplate);
}
