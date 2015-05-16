var EmailsReportData = function() {

 	return {

 		init: function() {

 			// Inicializacion de dataTables
 			App.datatables();

 			/* Initialize Datatables */
	        $('.table-emails-report').dataTable({
	            "bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource" : "/email/report/search",
		        "columns" : [
		            { "data": "id" },
		            { "data": "full_name" },
		            { "data": "email" },
		            { "data": "status" },
		            { "data": "order_id" },
		            { "data": "created_at" },
		            { "data": null }
		        ],
	            "aoColumnDefs": [
	            					{// ID
	            						"aTargets": [0],
						                "bSearchable": false,
						                "bSortable": false,
						                "bVisible":false
						            },
	            					{// Nombre
	            						"aTargets": [1],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Email
	            						"aTargets": [2],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Status
	            						"aTargets": [3],
						                "bSearchable": false,
						                "bSortable": true
						            },
						            {// # Orden
	            						"aTargets": [4],
						                "bSearchable": false,
						                "bSortable": true
						            },
						            {// Envio
	            						"aTargets": [5],
						                "bSearchable": false,
						                "bSortable": true
						            },
						            {// Acciones
	            						"aTargets": [6],
						                "bSearchable": false,
						                "bSortable": false,
						                "mRender": function (data, type, full) {
						                    return '<button class="btn btn-xs btn-primary" data-id="' + full.id + '"><i class="gi gi-message_empty"></i></button>';
						                },
						                "fnCreatedCell": function ( cell ) {
						                	$('button', cell).on('click', function(e) {

						                		var _id = $(this).data('id');

						                		$.d3POST('/email/report/notify',{id:_id},function(data){
						                			$('#templ_preview_iframe').contents()
												                          	  .find('html')
												                         	  .html(data.plantilla);
						                		});
						                		
						                		$('#modal-notification-view').modal('show');
						                	});
						                }
						            }
	            				],
	            "iDisplayLength": 10,
	            "aLengthMenu": [[10, 20, 30], [10, 20, 30]]
	        });

	        /* Add placeholder attribute to the search input */
	        $('.dataTables_filter input').attr('placeholder', 'Buscar');
 		}
 	}

 }();