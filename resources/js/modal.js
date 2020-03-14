function modal(titulo,description){
    document.body.innerHTML +=
    '<div class="modal alert" tabindex="-1" role="dialog">'+
    '<div class="modal-dialog" role="document"> '+
        '<div class="modal-content"> '+
        '<div class="modal-header">'+
            '<h5 class="modal-title">'+titulo+'</h5>'+
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
            '</button>'+
        '</div>'+
        '<div class="modal-body">'+
            '<p>'+description+ '</p>'+
        '</div>'+
        '<div class="modal-footer">'+
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
        '</div>'+
        '</div>'+
    '</div>'+
    '</div>';
}
