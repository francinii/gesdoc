



function advancedSearchfilter(colum,element){
    var dataTable= $("#table").DataTable()
   
     if ( dataTable.column(colum).search() !== element.value ) {
         dataTable
             .column(colum)
             .search( element.value )
             .draw();
     }
 
 
 }

 $( document ).ready(function() {

  dataTable = $('#table').DataTable( {
        destroy: true,
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5', 'print', 'csvHtml5'
        ]   
    });

        dataTable.column(1).data().sort().unique().each( function ( d, j ) {
            $("#actionHistory").append( '<option value="'+d+'">'+d+'</option>' )
        } );
        dataTable.column(5).data().sort().unique().each( function ( d, j ) {
            if(d!="")
            $("#flowHistory").append( '<option value="'+d+'">'+d+'</option>' )
        } );
   //     dataTable.dom =  'Bfrtip';
      //  dataTable.buttons =  ['excelHtml5', 'print', 'csvHtml5'];
     //   dom: 'Bfrtip',
     //   buttons: [
     //       'excelHtml5', 'print', 'csvHtml5'
     //   ]               
});