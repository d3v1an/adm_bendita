var CartsReportData = function() {

 	return {

 		init: function() {

 			// Inicializacion de dataTables
 			App.datatables();

 			/* Initialize Datatables */
	        var _dataTableOr = $('.table-carts-report').dataTable({
						            "bProcessing": true,
							        "bServerSide": true,
							        "sAjaxSource" : "/customer/carts/search",
							        "columns" : [
							            { "data": "user_id" },
							            { "data": "full_name" },
							            { "data": "email" },
							            { "data": "type" },
							            { "data": "total" },
							            { "data": null }
							        ],
						            "aoColumnDefs": [
						            					{// Usuario id
						            						"aTargets": [0],
											                "bSearchable": false,
											                "bSortable": false
											            },
						            					{// Nombre
						            						"aTargets": [1],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Email
						            						"aTargets": [2],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Tipo
						            						"aTargets": [3],
											                "bSearchable": false,
											                "bSortable": false
											            },
											            {// Total
						            						"aTargets": [4],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// # Guia
						            						"aTargets": [5],
											                "bSearchable": true,
											                "bSortable": true,
											                "mRender": function (data, type, full) {
																return '<button class="btn btn-default btn-xs" type="button" data-uid="' + full.user_id + '" data-total="' + full.total + '"><i class="gi gi-eye_open"></i></button>';
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('button', cell).on('click', function(e) {

											                		var _id 	= $(this).data('uid');
											                		var _total 	= $(this).data('total');

											                		$.d3POST('/customer/carts/detail',{id:_id},function(data) {

											                			//console.log(data);
											                			//return false;

											                			if(data.status==true) {

											                				$("span.total-basket").html(data.total);

											                				var _tr = '';
				
																			$('.table-basket-detail').dataTable().fnDestroy();
															    			
															    			var _table = $('table.table-basket-detail tbody');
															    				_table.empty('');

															    			if(data.basket.length>0) {

															    				$.each(data.basket,function(i, item){
															    					_tr += '<tr id="_uid_' + item.user_id + '">';
																					_tr += '	<td class="text-center"><img class="img-thumbnail" alt="avatar" src="' + data.url + item.code + '_tumb.jpg"></td>';
																					_tr += '	<td class="text-center">' + item.code + '</td>';
																					_tr += '	<td>' + item.description + '</td>';
																					_tr += '	<td class="text-center">' + item.user.type.label + '</td>';
																					_tr += '	<td class="text-center">' + item.currency + '</td>';
																					_tr += '	<td class="text-center">$' + parseInt(item.price).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + '</td>';
																					_tr += '	<td class="text-center">' + item.quanty + '</td>';
																					_tr += '	<td class="text-center">$' + parseInt(item.total).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + '</td>';
																					_tr += '</tr>';
															    				});

																				_table.append(_tr);

																				$('.table-basket-detail').dataTable({
																		            "aoColumnDefs": [
																							            {// Pic
																		            						"aTargets": [0],
																							                "bSearchable": false,
																							                "bSortable": false
																							            },
																		            					{// Codigo
																		            						"aTargets": [1],
																							                "bSearchable": true,
																							                "bSortable": false
																							            },
																							            {// Descripcion
																		            						"aTargets": [2],
																							                "bSearchable": true,
																							                "bSortable": false
																							            },
																							            {// Tipo
																		            						"aTargets": [3],
																							                "bSearchable": true,
																							                "bSortable": false
																							            },
																							            {// Moneda
																		            						"aTargets": [4],
																							                "bSearchable": true,
																							                "bSortable": false
																							            },
																							            {// Precio unitario
																		            						"aTargets": [5],
																							                "bSearchable": false,
																							                "bSortable": false
																							            },
																							            {// Cantidad
																		            						"aTargets": [6],
																							                "bSearchable": false,
																							                "bSortable": false
																							            },
																							            {// Sub total
																		            						"aTargets": [7],
																							                "bSearchable": false,
																							                "bSortable": false
																							            }
																		            				],
																		            "iDisplayLength": 5,
																		            "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todo"]]
																		        });
															    			}

											                				$("#modal-detail-view").modal('show');
											                			} else {
											                				$.bootstrapGrowl(data.message, {
														                        type: "danger",
														                        delay: 4500,
														                        allow_dismiss: true
														                    });
											                			}
											                		});

											                	});
											                }
											            }
						            				],
						            "order": [ 0, 'desc' ],
						            "iDisplayLength": 10,
						            "aLengthMenu": [[10, 20, 30], [10, 20, 30]]
						        });

	        /* Add placeholder attribute to the search input */
	        $('.dataTables_filter input').attr('placeholder', 'Buscar');

 		}
 	}

 }();