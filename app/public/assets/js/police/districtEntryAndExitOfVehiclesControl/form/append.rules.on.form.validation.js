$(document).ready(function () {
    appendRuleRequiredVehicleBodyTypeId();

    appendRuleRequiredReasonForTripId();

    appendRuleRequiredIdentityCardTypeId();
});


function appendRuleRequiredVehicleBodyTypeId() {
    $('input[name="vehicleBodyTypeId"]').rules("add", {required: true});
}

function appendRuleRequiredReasonForTripId() {
    $('input[name="reasonForTripId"]').rules("add", {required: true});
}

function appendRuleRequiredIdentityCardTypeId() {
    $('input[name*="identityCardTypeId"]').rules("add", {required: true});
}
