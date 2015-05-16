var DashBoardData   = function(id) {

 	return {

 		init: function() {

 			App.datatables();

 			$('.table-recent-users').dataTable({
	            "aoColumnDefs": [
	            					{// Nombre
	            						"aTargets": [0],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Email
	            						"aTargets": [1],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Ciudad
	            						"aTargets": [2],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Estado
	            						"aTargets": [3],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Telefono
	            						"aTargets": [4],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Status
	            						"aTargets": [5],
						                "bSearchable": false,
						                "bSortable": false
						            },
						            {// Interes
	            						"aTargets": [6],
						                "bSearchable": true,
						                "bSortable": true
						            },
						            {// Tipo
	            						"aTargets": [7],
						                "bSearchable": false,
						                "bSortable": false
						            }
	            				],
	            "iDisplayLength": 10,
	            "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todo"]]
	        });

			$('table.table-recent-users tbody tr td').on('change','select',function(){
				
				var _select_type 	= $(this).prop('id');
				var _uid 			= $(this).data('uid');
				var _option 		= $(this).val();

				if(_select_type=='status') {
					
					$.d3POST('/user/update/status',{uid:_uid,status:_option},function(data){
						if(data.status==true) {
							$.bootstrapGrowl(data.message, {
	                            type: "success",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
						} else {
							$.bootstrapGrowl(data.message, {
	                            type: "danger",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
						}
					});

				} else if(_select_type=='type') {

					$.d3POST('/user/update/type',{uid:_uid,status:_option},function(data){
						if(data.status==true) {
							$.bootstrapGrowl(data.message, {
	                            type: "success",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
						} else {
							$.bootstrapGrowl(data.message, {
	                            type: "danger",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
						}
					});
					
				}

			});
 		}
 	}

 }();