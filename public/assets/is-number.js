function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function isNumberNotZeroFirst(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

        if (evt.value.length <= 0) {
            if (charCode == 48)
            return false;
        }

    return true;
}

function initNumber(evt) {
    evt.on('keypress', function() { return isNumber(this.value) })
    evt.on('keyup', function() { return isNumber(this.value) })
    evt.on('keydown', function() { return isNumber(this.value) })
}

function initNumberNotZeroFirst(evt) {
    evt.on('keypress', function() { return isNumberNotZeroFirst(this.value) })
    evt.on('keyup', function() { return isNumberNotZeroFirst(this.value) })
    evt.on('keydown', function() { return isNumberNotZeroFirst(this.value) })
}
