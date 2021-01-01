import Cookies from 'js-cookie'

$(document).ready(function () {
    if (Cookies.get('post-instructions') !== 'read') {
        $('#create-post-modal').modal();
    }
});

$('#create-post-modal').on('hidden.bs.modal', function (e) {
    Cookies.set('post-instructions', 'read');
});
