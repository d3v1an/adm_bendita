var CustomersReportData = function() {

 	return {

 		init: function() {

 			// Inicializacion de dataTables
 			App.datatables();

 			/* Initialize Datatables */
	        var _dataTableOr = $('.table-customers-report').dataTable({
						            "bProcessing": true,
							        "bServerSide": true,
							        "sAjaxSource" : "/customer/list",
							        "columns" : [
							            { "data": "id" },
							            { "data": "full_name" },
							            { "data": "email" },
							            { "data": "city" },
							            { "data": "state" },
							            { "data": "address" },
							            { "data": "phone" },
							            { "data": "interest" },
							            { "data": "type" },
							            { "data": "status" },
							            { "data": null }
							        ],
						            "aoColumnDefs": [
						            					{// Usuario id
						            						"aTargets": [0],
											                "bSearchable": true,
											                "bSortable": true
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
											            {// Ciudad
						            						"aTargets": [3],
											                "bSearchable": true,
											                "bSortable": true
											            },
											            {// Estado
						            						"aTargets": [4],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Direccion
						            						"aTargets": [5],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Telefono
						            						"aTargets": [6],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Interes
						            						"aTargets": [7],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Tipo
						            						"aTargets": [8],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Estatus
						            						"aTargets": [9],
											                "bSearchable": true,
											                "bSortable": true,
											                "mRender": function (data, type, full) {
											                	return (full.status==1?'<span class="label label-success">Activo</span>':(full.deleted==1?'<span class="label label-danger">Eliminado</span>':'<span class="label label-warning">Inactivo</span>'));
											                }
											            },
											            {// Acciones
						            						"aTargets": [10],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _button  = '<div class="btn-group btn-group-xsm">';
											                		_button += '	<button data-uid="' + full.id + '" data-cmd="view" class="btn btn-xs btn-default"><i class="gi gi-eye_open"></i></button>';
											                		_button += '	<button data-uid="' + full.id + '" data-cmd="del" class="btn btn-xs btn-default" ' + (full.deleted==1?'disabled':'') + '><i class="gi gi-bin"></i></button>';
											                		_button += '</div>';

																return _button;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('button', cell).on('click', function(e) {

											                		var _uid = $(this).data('uid');
											                		var _cmd = $(this).data('cmd');

											                		if(_cmd=='view') {
											                			// Obtenemos la informacion del usuario

											                			$.d3POST('/customer/info',{id:_uid},function(data) {
											                				console.log(data);
											                				//return false;
											                				if(data.status==true) {

											                					var _general_form = $('#form-user-general-info');

											                					$('#name',_general_form).val(data.user.name);
											                					$('#password',_general_form).val(Base64.decode(data.user.password_recovery));
											                					$('#phone',_general_form).val(data.user.phone);
											                					$('#birthday',_general_form).val(data.user.birthday);
											                					$('#col',_general_form).val(data.user.suburb);
											                					$('#cp',_general_form).val(data.user.postal_code);
											                					$('#country',_general_form).val(data.user.country_id);
											                					$('#type',_general_form).val(data.user.type_id);
											                					$('#email',_general_form).val(data.user.email);
											                					$('#lada',_general_form).val(data.user.lada);
											                					$('#gender',_general_form).val( (data.user.gender=='f'?'Femenino':'Masculino') );
											                					$('#address',_general_form).val(data.user.address);
											                					$('#city',_general_form).val(data.user.city);
											                					$('#state',_general_form).val(data.user.state_id);
											                					$('#interest',_general_form).val(data.user.interest.label);
											                					$('#status',_general_form).val(data.user.status);

											                					var _facturacion_form = $('#form-user-facturacion-info');

											                					$('#razon_social',_facturacion_form).val(data.user.df_razon_social);
											                					$('#tipo',_facturacion_form).val(data.user.df_tipo);
											                					$('#cp',_facturacion_form).val(data.user.df_cp);
											                					$('#city',_facturacion_form).val(data.user.df_ciudad);
											                					$('#country',_facturacion_form).val(data.user.df_country_id);
											                					$('#rfc',_facturacion_form).val(data.user.df_rfc);
											                					$('#address',_facturacion_form).val(data.user.df_direccion);
											                					$('#colonia',_facturacion_form).val(data.user.df_colonia);
											                					$('#state',_facturacion_form).val(data.user.df_state_id);

											                					var _envio_form = $('#form-user-envio-info');

											                					$('#address',_envio_form).val(data.user.de_direccion);
											                					$('#colonia',_envio_form).val(data.user.de_colonia);
											                					$('#country',_envio_form).val(data.user.de_country_id);
											                					$('#cp',_envio_form).val(data.user.de_cp);
											                					$('#ciudad',_envio_form).val(data.user.de_ciudad);
											                					$('#state',_envio_form).val(data.user.de_state_id);

											                				} else {
											                					$.bootstrapGrowl(data.message, {
														                            type: "danger",
														                            delay: 4500,
														                            allow_dismiss: true
														                        });
											                				}
											                			});

											                			$('#modal-user-detail').modal('show');
											                		} else if(_cmd=='del') {

											                			var _confirm = confirm('Esta seguro de eliminar/inhabilitar este usuario?');

											                			if(_confirm==true) {

											                				$.d3POST('/customer/del',{id:_uid},function(data) {
											                					if(data.status==true) {
																					$.bootstrapGrowl(data.message, {
															                            type: "success",
															                            delay: 4500,
															                            allow_dismiss: true
															                        });
															                        // Obtenemos la pagina actual
															        				var _cp = _dataTableOr.dataTable().fnPagingInfo().iPage;
															        				
															        				// Actualizamos la pagina principal
															        				_dataTableOr.dataTable()._fnAjaxUpdate();
															        				
															        				// Movemos el cursor de la pagina
															        				_dataTableOr.dataTable().fnPageChange(_cp,true);
																				} else {
																					$.bootstrapGrowl(data.message, {
															                            type: "danger",
															                            delay: 4500,
															                            allow_dismiss: true
															                        });
																				}
											                				});
											                			}

											                		}

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

	        //$('#modal-user-detail').modal('show');

	        $('#modal-user-detail').on('hidden.bs.modal', function (e) {
				$('#form-user-general-info').trigger('reset');
				$('#fform-user-facturacion-info').trigger('reset');
				$('#form-user-envio-info').trigger('reset');
			});

 		}
 	}

 }();