// JavaScript Document

var editor = new $.fn.dataTable.Editor( {
    ajax:  './connect/edit_data.php?table=contact_me',
    table: '#myTable',
	idSrc:  0,
    fields: [
	  ],
	formOpttions: {
		inline: {
			//onBlur: 'submit'
			}
		}
} );

	$('#myTable').on( 'click', 'tbody td.edit_a', function (e) {
        editor.inline( this );
    } );

  
  
//For Orders Table  
var table = $('#myTable').DataTable( {
   "processing": true,
   "serverSide": true,
   "ajax": "./connect/get_data.php?table=contact_me",
   "bSortCellsTop" : true,
   "rowId" : "0",
   dom: '<B<"datatable_dom_pull_left"f><"pull-right"l>r<t>lip>',
   'lengthMenu': [[20, 50, 100, 200, -1], [20, 50, 100, 200, 'All']],
   columns: [
        { data: null, defaultContent: '', className: 'select-checkbox', orderable: false },
		{ data: 1},
		{ data: 2},
		{ data: 3},
		{ data: 4},
		{ data: 5}
        // etc
    ], 
	
	"order" : [[1, "asc"]],
	  
    //select: true,
	select: {
		style: 'os',
		selector: 'td:first-child'
		},
    buttons: [
	    { extend: 'remove', editor: editor },
		{
                extend: 'collection',
                text: 'Export',
                buttons: [
                    'print',
                    'excel',
                    'csv',
                ]
            },
		{ extend: 'colvis', collectionLayout: 'fixed three-column' },
		
    ]
} );


$('#myTable thead tr:eq(1) th').each( function (i) {
        
		 if($(this).hasClass('sch')){
			 $(this).html('<input type="text" placeholder="search"/>')
			 $('input', this).on('keyup change', function(){
				if ( table.column(i).search() !== this.value ) {
					
					
					table
						.column(i)
						.search( this.value )
						.draw();
				}
			} );
		 }
		 
});



