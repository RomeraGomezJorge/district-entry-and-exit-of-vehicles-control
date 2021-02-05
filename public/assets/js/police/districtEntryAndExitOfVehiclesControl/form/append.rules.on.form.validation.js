$(document).ready(function () {
    appendRuleRequiredVehicleBodyTypeId();

    appendRuleRequiredReasonForTripId()
});


function appendRuleRequiredVehicleBodyTypeId() {
    $('input[name="vehicleBodyTypeId"]').rules("add", {
        required: true
    });
}

function appendRuleRequiredReasonForTripId() {
    $('input[name="reasonForTripId"]').rules("add", {
        required: true
    });
}
