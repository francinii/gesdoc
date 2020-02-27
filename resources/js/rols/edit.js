function edit(id, description) {
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    $("#edit").modal("show");
}

jQuery(document).ready(function() {
    jQuery("#submit").click(function(e) {
        e.preventDefault();
        var id = $("input[name=id]").val();
        var description = $("input[id=description]").val();
       /* $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').val()
            }
        });*/

        jQuery.ajax({
            url: "rols/" + id,
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                _method:$("input[name=_method]").val(),
                id: jQuery("#id").val(),
                description: jQuery("#description").val()
            },
            success: function(result) {
                jQuery(".alert").show();
                jQuery(".alert").html(result.success);
            }
        });
    });
});
