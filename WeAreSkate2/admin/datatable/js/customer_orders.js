// JavaScript Document
var gl_order_id = "";

var payment_status = {'0': 'Failed', '1': 'Sucessfull'};
var order_status = {'0': '', '1': 'Processing', '2': 'Shipping', '3': 'Completed'};

var editor = new $.fn.dataTable.Editor( {
    ajax:  './connect/edit_data.php',
    table: '#myTable',
	idSrc:  1,
    fields: [
		{ label: 'Payment Status',  name: 3, type : 'select', options:[{label: 'Failed', value: '0'}, {label: 'Sucessfull', value: '1'}]   },
		{ label: 'Order Status',  name: 4, type : 'select', options: [{label: 'none', value: '0'}, {label: 'Processing', value: '1'}, {label: 'Shipping', value: '2'}, {label: 'Completed', value: '3'}]   },
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
   "ajax": "./connect/get_data.php?table=orders",
   "bSortCellsTop" : true,
   "rowId" : "1",
   dom: '<B<"datatable_dom_pull_left"f><"pull-right"l>r<t>lip>',
   'lengthMenu': [[20, 50, 100, 200, -1], [20, 50, 100, 200, 'All']],
   columns: [
        { data: null, defaultContent: '', className: 'select-checkbox', orderable: false },
		{ data: 1, render: function(data, type, row){  return  '<a onclick="show_items(\''+row[1]+'\')">'+row[1]+'</a>';  }},
		{ data: 2, render: $.fn.dataTable.render.number(',', '.', 2, 'R') },
		{ data: 3,  render: function(data, type, row){  return payment_status[row[3]]}},
		{ data: 4,  render: function(data, type, row){  return order_status[row[4]]}},
		{ data: 5},
		{ data: 6},
		{ data: 7},
		{ data: 8},
		{ data: 9}
        // etc
    ], 
	
	"order" : [[5, "desc"]],
	  
    //select: true,
	select: {
		style: 'os',
		selector: 'td:first-child'
		},
    buttons: [
	    { extend: 'edit',   editor: editor },
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





//For Order Items
var table2 = $('#myTable2').DataTable( {
   ajax: {
			   "url" : "connect/get_data.php?table=order_items",
				data: function(d){
					d.order_id = gl_order_id;
			   },
   	},
   "bSortCellsTop" : true,
   "rowId" : "1",
   dom: '<B<"datatable_dom_pull_left"f><"pull-right"l>r<t>lip>',
   'lengthMenu': [[-1], ['All']],
   "footerCallback" : footer_sum,
   columns: [
    	{ data: 1, render: function(data, type, row){  return  '<img src="../images/'+row[2]+'"><br>'+row[1]+'<br><small>'+row[5]+'</small>';  }},
		{ data: 3},
		{ data: 4},
		{ data: 6, render: $.fn.dataTable.render.number(',', '.', 2, 'R')},
        // etc
    ], 
	  
    select: {
		style: 'os',
		selector: 'td:first-child'
		},
    buttons: [
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

function  show_items(order_id){
	
	gl_order_id = order_id;
	table2.ajax.reload();
	$("#cur_order").html(order_id);	
	item_wrapper_display(1);
	
}

function  item_wrapper_display(ch){
    if(ch == 0)
	$("#item_wrapper").hide();
	else
	$("#item_wrapper").show();	
	
	
}




function footer_sum(row, data, start, end, display){
	var api = this.api(), data;
	// remove the formatting to get inteher or float data for summation
	var intVal =  function(i){
		return typeof i === 'string'? i.replace(/[\$,]/g, '')*1 : typeof i === 'number'? i : 0;
		}
	 
	 
	 //Total Calc over this pages
	 var pageTotal = api.column(3, {page: 'current'}).data().reduce(function(a, b){ return intVal(a) + intVal(b); }, 0);
     var formatter = new Intl.NumberFormat('en-US',{style: 'currency', currency: 'XAR',});	 
	$(api.column(3).footer()).html(formatter.format(pageTotal) );
}	

	  
