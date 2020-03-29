$.fn.select2.defaults.set( "theme", "bootstrap" );
$(document).ready(function() {
    $('.tip').tooltip();
    $('.select').select2();
    $(".file").fileinput({'showUpload':false});
    $('.validate').formValidation();

    $(document).on('click', '[data-delete]', function(e) {
        e.preventDefault();
        var self = $(this);
        var token = self.data('token');
        var action = self.data('action');
        var row = self.closest('tr');
        saa_alert(token, action, row);
        return false;
    });

});

function sa_alert(title, message, level, overlay) {
    level = level || 'success';
    overlay = overlay || '';
    swal({
        title: title,
        text: message,
        type: level,
        timer: overlay == '' ? 2000 : 60000,
        confirmButtonText: "Okay"
    });
}

function saa_alert(token, action, row) {
    swal({
        title: "Are you sure?",
        text: "This action can't be reverted back and the record will be delete permanently.",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
        $.ajax({
            url: action,
            type: 'POST',
            data: {_method: 'delete', _token :token},
            success: function(data) {
                if (data.status == 'success') {
                    // row.remove();
                    table.draw();
                    sa_alert(data.status, data.message);
                }
            }
        });
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
