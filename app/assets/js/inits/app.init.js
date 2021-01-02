$(document).ready(function () {
    let swalElement = $('#swal');
    if (swalElement.length) {
        swal(swalElement.data('title'), swalElement.data('text'), swalElement.data('type'));
    }
});
