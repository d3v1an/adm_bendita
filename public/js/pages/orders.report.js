var OrdersReportData = function() {

 	return {

 		init: function() {

 			// Inicializacion de dataTables
 			App.datatables();

 			// Tabla de detalle
 			var _dataTableOi = undefined;//$('.table-order-detail').dataTable();

 			/* Initialize Datatables */
	        var _dataTableOr = $('.table-orders-report').dataTable({
						            "bProcessing": true,
							        "bServerSide": true,
							        "sAjaxSource" : "/customer/orders/report/search",
							        "columns" : [
							            { "data": "id" },
							            { "data": "full_name" },
							            { "data": "created_at" },
							            { "data": "updated_at" },
							            { "data": "parcel_id" },
							            { "data": "parcel_number" },
							            { "data": "shipping_cost" },
							            { "data": "sub_total" },
							            { "data": "total" },
							            { "data": "order_status_id" },
							            { "data": "payed" },
							            { "data": null }
							        ],
						            "aoColumnDefs": [
						            					{// # Orden
						            						"aTargets": [0],
											                "bSearchable": false,
											                "bSortable": true
											            },
						            					{// Nombre
						            						"aTargets": [1],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Registro
						            						"aTargets": [2],
											                "bSearchable": false,
											                "bSortable": true
											            },
											            {// Actualizacion
						            						"aTargets": [3],
											                "bSearchable": false,
											                "bSortable": true
											            },
											            {// Paqueteria
						            						"aTargets": [4],
											                "bSearchable": true,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _select  = '<select id="parcel_' + full.id + '" name="parcel_' + full.id + '" data-oid="' + full.id + '">';
											                		_select += '	<option value="0" ' + (full.parcel_id==0?'selected':'') + '>Ninguna</option>';
											                		$.each(full.parcels,function(i,item){
											                			_select += '	<option value="' + item.id + '" ' + (full.parcel_id==item.id?'selected':'') + '>' + item.label + '</option>';
											                		});
											                		_select += '</select>';

											                	return _select;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('select', cell).on('change', function(e) {

											                		var _id 	= $(this).data('oid');
											                		var _parcel = $(this).val();

											                		$.d3POST('/customer/orders/parcel/update',{id:_id, parcel:_parcel},function(data){
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

											                	});
											                }
											            },
											            {// # Guia
						            						"aTargets": [5],
											                "bSearchable": true,
											                "bSortable": true,
											                "mRender": function (data, type, full) {

											                	var _input  = '<div class="input-group">';
																	_input += '    <input type="text" placeholder="Guia" ' + (full.parcel_number!=0?'value="' + full.parcel_number + '"':'') + ' class="form-control" name="gnumber_' + full.id + '" id="gnumber_' + full.id + '" style="max-width:100px;">';
																	_input += '    <span class="input-group-btn">';
																	_input += '        <button class="btn btn-success" type="button" data-oid="' + full.id + '"><i class="gi gi-ok_2"></i></button>';
																	_input += '    </span>';
																	_input += '</div>';

																return _input;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('button', cell).on('click', function(e) {

											                		var _id 	= $(this).data('oid');
											                		var _guide 	= $('input#gnumber_'+_id).val();

											                		if(_guide=='') {
											                			$.bootstrapGrowl('Ingrese un numero de guia valido', {
													                        type: "danger",
													                        delay: 4500,
													                        allow_dismiss: true
													                    });
													                    return false;
											                		}

											                		$.d3POST('/customer/orders/num_guide',{id:_id, guide:_guide},function(data){
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

											                	});
											                }
											            },
											            {// Coste de envio
						            						"aTargets": [6],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _input  = '<div class="input-group">';
																	_input += '    <input type="text" placeholder="$ Envio" ' + (full.shipping_cost!=0?'value="' + full.shipping_cost + '"':'') + ' class="form-control" name="scost_' + full.id + '" id="scost_' + full.id + '" style="max-width:100px;">';
																	_input += '    <span class="input-group-btn">';
																	_input += '        <button class="btn btn-success" type="button" data-oid="' + full.id + '" data-sub="' + full.sub_total + '"><i class="gi gi-ok_2"></i></button>';
																	_input += '    </span>';
																	_input += '</div>';

																return _input;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('button', cell).on('click', function(e) {

											                		var _id 	= $(this).data('oid');
											                		var _icost 	= parseInt($('input#scost_'+_id).val());
											                		var _subtot = parseInt($(this).data('sub'));

											                		if(_icost=='') {
											                			$.bootstrapGrowl('Ingrese costo valido', {
													                        type: "danger",
													                        delay: 4500,
													                        allow_dismiss: true
													                    });
													                    return false;
											                		}

											                		$.d3POST('/customer/orders/shipping_cost',{id:_id, cost:_icost},function(data){
											                			if(data.status==true) {
											                				
											                				$.bootstrapGrowl(data.message, {
														                        type: "success",
														                        delay: 4500,
														                        allow_dismiss: true
														                    });

														                    var _new_total = '$'+(_subtot+_icost).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;});

														                    $('span#_tot_'+_id).html(_new_total);
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
											            },
											            {// Sub-Total
						            						"aTargets": [7],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _sub_total = '$'+full.sub_total.toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;});
											                	return _sub_total;
											                }
											            },
											            {// Total
						            						"aTargets": [8],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _total = '<span id="_tot_' + full.id + '">$'+full.total.toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + '</span>';
											                	return _total;
											                }
											            },
											            {// Estatus
						            						"aTargets": [9],
											                "bSearchable": false,
											                "bSortable": true,
											                "mRender": function (data, type, full) {

											                	var _select  = '<select id="status_' + full.id + '" name="status_' + full.id + '" data-oid="' + full.id + '">';
											                		_select += '	<option value="1" ' + (full.status_id==1?'selected':'') + '>Pendiente</option>';
											                		_select += '	<option value="2" ' + (full.status_id==2?'selected':'') + '>Procesada</option>';
											                		_select += '	<option value="3" ' + (full.status_id==3?'selected':'') + '>Enviada</option>';
											                		_select += '	<option value="4" ' + (full.status_id==4?'selected':'') + '>Cancelada</option>';
											                		_select += '</select>';

											                    return _select;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('select', cell).on('change', function(e) {

											                		var _id 	= $(this).data('oid');
											                		var _status = $(this).val();

											                		$.d3POST('/customer/orders/status/update',{id:_id, status:_status},function(data){
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

											                	});
											                }
											            },
											            {// Pagada
						            						"aTargets": [10],
											                "bSearchable": false,
											                "bSortable": true,
											                "mRender": function (data, type, full) {

											                	var _check = '<input type="checkbox" value="payed" id="payed_' + full.id + '" name="payed_' + full.id + '" ' + (full.payed==1?'checked':'') + ' data-oid="' + full.id + '">';

											                	return _check;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$(':checkbox', cell).on('change', function(e) {

											                		var _id 	= $(this).data('oid');
											                		var _status = ($(this).is(":checked")?"1":"0");

											                		$.d3POST('/customer/orders/payed/update',{id:_id, status:_status},function(data){
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

											                	});
											                }
											            },
											            {// Acciones
						            						"aTargets": [11],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _buttons  = '<div class="btn-group btn-group-xsm">';
											                		_buttons += '	<button class="btn btn-xs btn-default" data-cmd="view" data-oid="' + full.id + '"><i class="gi gi-eye_open"></i></button>';
											                		_buttons += '	<button class="btn btn-xs btn-default" data-cmd="email" data-oid="' + full.id + '"><i class="gi gi-message_out"></i></button>';
											                		_buttons += '</div>';

											                    return _buttons;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('button', cell).on('click', function(e) {

											                		var _cmd = $(this).data('cmd');
											                		var _oid = $(this).data('oid');

											                		if(_cmd=='view') {
											                			$('#order_id','#form-additional-data').val(_oid);
											                			$.orderDetailHandler(_oid,true);
											                		}
											                		else if(_cmd=='email') {
											                			$('#order_id','#form-notify').val(_oid);
											                			$('#order_id','#form-additional-data').val(_oid);
											                			$('#modal-order-notify').modal('show');
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

	        // Fix para overmodal
	        $('#modal-order-item-edit').on('hidden.bs.modal', function(e){
                if($('#modal-order-view').css('display')=='block') {
                   $('body').addClass('modal-open'); 
                }
                $('#form-item-replace').trigger('reset');
            });

            // Autocomplete
            var _form 		= $('#form-item-replace')
            var $input 		= $('#code',_form);

            $input.typeahead({
            	source:function(request, response) {

            		var _state 	= $input.val();
            		var _term 	= request.term;

					$.d3POST('/customer/orders/detail/item/search',{state:_state, term:_term},function(data){
						response(data);
					});
            	},
            	autoSelect: true,
            	minLength: 2,
            	items:'all',
            	displayText: function(item) {
            		return item.code + ' (' + item.description + ')';
            	}
            });
            
            $input.change(function() {
			    
			    var _form 	= $('#form-item-replace');

			    var current 	= $input.typeahead("getActive");
			    var _price 		= $('#price',_form);
			    var _quanty 	= $('#quanty',_form);
			    var _sub_tot 	= $('#sub_total',_form);
			    var _ptype 		= $('#ptype',_form);
			    var _nid 		= $('#n_item_id',_form);

			    var _currency 	= $('#currency',_form).val();
			    var _utype 		= $('#utype_id',_form).val();

			    if (current) {

			    	var _price_type 	= (_currency=='MXN'?current.price_public:current.price_public_dls);
			    	var _utype_label 	= 'Publico';

			    	if(_utype==2) {
			    		_price_type 	= (_currency=='MXN'?current.price_half_wholesale:current.price_half_wholesale_dls);
			    		_utype_label 	= 'Medio mayorista';
			    	} else if(_utype==3) {
			    		_price_type 	= (_currency=='MXN'?current.price_wholesale:current.price_wholesale_dls);
			    		_utype_label 	= 'Mayorista';
			    	} else if(_utype==4) {
			    		_price_type 	= (_currency=='MXN'?current.price_dealer:current.price_dealer_dls);
			    		_utype_label 	= 'Distribuidor';
			    	}

			    	$input.val(current.code);
			    	_price.val(_price_type);
			    	_quanty.val(1);
			    	_ptype.val(_utype_label);
			    	_sub_tot.val(_price_type);
			    	_nid.val(current.id);

			    	//console.log(current.code.toLowerCase() + ' A');
			    	//console.log($input.val() + ' B');
			        // Some item from your model is active!
			        //if (current.code.toLowerCase() == $input.val()) {
			        //	console.log('aaa');
			            // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
			        //} else {
			        //	console.log('bbb');
			        	//$input.val('Mamalon');
			            // This means it is only a partial match, you can either add a new item 
			            // or take the active if you don't want new items
			        //}
			    }
			}); 

			$('#quanty','#form-item-replace').on('keypress focusout keyup',function(e){
				
				var _form 		= $('#form-item-replace');
				var _quanty 	= parseInt($('#quanty',_form).val());
				var _price 		= parseInt($('#price',_form).val());

				$('#sub_total',_form).val(_price*_quanty);

			});

			$('.btn-item-replace').click(function(e){
				
				var _form 			= $('#form-item-replace');

				var _order_id 		= $('#order_id', _form).val();
				var _original_item 	= $('#o_item_id', _form).val();
				var _new_item 		= $('#n_item_id', _form).val();
				var _user_type		= $('#utype_id', _form).val();
				var _currency 		= $('#currency', _form).val();
				var _lang 			= $('#lang', _form).val();
				var _uid 			= $('#uid',_form).val();
				var _trid 			= $('#trid',_form).val();

				var _code 			= $('#code', _form).val();
				var _price 			= $('#price', _form).val();
				var _quanty			= $('#quanty', _form).val();
				var _sub_total		= $('#sub_total', _form).val();

				var _params 		= {
										order_id:_order_id,
										original_item_id:_original_item,
										new_item_id:_new_item,
										user_type:_user_type,
										code:_code,
										price:_price,
										quanty:_quanty,
										sub_total:_sub_total,
										currency:_currency,
										lang:_lang,
										uid:_uid
									};

				$.d3POST('/customer/orders/detail/item/replace',_params,function(data){

					if(data.status==true) {
        				
        				$.bootstrapGrowl(data.message, {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });

        				// Recargamos la tabla de detalles
        				$.orderDetailHandler(data.oi);
        				
        				// Obtenemos la pagina actual
        				var _cp = _dataTableOr.dataTable().fnPagingInfo().iPage;
        				
        				// Actualizamos la pagina principal
        				_dataTableOr.dataTable()._fnAjaxUpdate();
        				
        				// Movemos el cursor de la pagina
        				_dataTableOr.dataTable().fnPageChange(_cp,true);

        				// Ocultamos el dialogo de remplazo de articulo
        				$('#modal-order-item-edit').modal('hide');

        			} else {
        				$.bootstrapGrowl(data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
        			}

				});

				e.preventDefault();
			});

			// Handler para refrescar 
			$.orderDetailHandler = function(_oid,_show_modal) {
       					
				var _tr = '';
				
				$('.table-order-detail').dataTable().fnDestroy();
    			
    			var _table = $('table.table-order-detail tbody');
    				_table.empty('');

    			$.d3POST('/customer/orders/detail',{id:_oid},function(data){
    				
        			if(data.status==true) {
        				
        				if(data.order.items.length>0) {
        					
        					$.each(data.order.items,function(i, item){

								_tr += '<tr id="_oid_' + item.id + '">';
								_tr += '	<td>' + item.id + '</td>';
								_tr += '	<td class="text-center"><input type="checkbox" value="item" id="itm_' + item.id + '" name="itm_' + item.id + '" data-oid="' + data.order.id + '" data-iid="' + item.id + '" ' + (item.done==1?'checked disabled':'') + '></td>';
								_tr += '	<td class="text-center"><img class="img-thumbnail" alt="avatar" src="' + data.url + item.product.code + '_tumb.jpg"></td>';
								_tr += '	<td class="text-center">' + item.product.code + '</td>';
								_tr += '	<td>' + item.product.description + '</td>';
								_tr += '	<td class="text-center">' + data.order.user.type.label + '</td>';
								_tr += '	<td class="text-center">' + data.order.user.currency + '</td>';
								_tr += '	<td class="text-center">$' + parseInt(item.price).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + '</td>';
								_tr += '	<td class="text-center">' + item.quanty + '</td>';
								_tr += '	<td class="text-center">$' + parseInt(item.total).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + '</td>';
								_tr += '	<td class="text-center">';
								_tr += '		<div class="btn-group btn-group-xs">';
			    				_tr += '			<button class="btn btn-default" id="_e_btd_' + item.id + '" data-cmd="edit" data-oid="' + data.order.id + '" data-trid="' + item.id + '" data-iid="' + item.id + '" data-utype="' + data.order.user.type.label + '" data-currency="' + data.order.user.currency + '" data-lang="' + item.languaje + '" data-uid="' + data.order.user_id + '" ' + (item.done==1?'disabled':'') + '><i class="fa fa-pencil"></i></button>';
			    				_tr += '			<button class="btn btn-danger" id="_d_btd_' + item.id + '" data-cmd="del" data-oid="' + data.order.id + '" data-iid="' + item.id + '" ' + (item.done==1?'disabled':'') + '><i class="fa fa-times"></i></button>';
								_tr += '		</div>';
								_tr += '</td>';

							});

							_table.append(_tr);

							_dataTableOi = $('.table-order-detail').dataTable({
									            "aoColumnDefs": [
									            					{// ID
									            						"aTargets": [0],
														                "bSearchable": false,
														                "bSortable": false,
														                "bVisible":false
														            },
									            					{// Checkbox
									            						"aTargets": [1],
														                "bSearchable": false,
														                "bSortable": false,
														                "fnCreatedCell": function ( cell ) {
														                	$(':checkbox', cell).on('change', function(e) {

														                		var _orderId 	= $(this).data('oid');
														                		var _itemId 	= $(this).data('iid');
														                		var _this 		= $(this);

														                		$.d3POST('/customer/orders/detail/item',{item_id:_itemId},function(data){

														                			if(data.status==true) {
														                				$.bootstrapGrowl(data.message, {
																	                        type: "success",
																	                        delay: 4500,
																	                        allow_dismiss: true
																	                    });
																	                    _this.prop('disabled', true);
																	                    $('button#_e_btd_' + _itemId).prop('disabled',true);
																	                    $('button#_d_btd_' + _itemId).prop('disabled',true);
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
														            },
														            {// Pic
									            						"aTargets": [2],
														                "bSearchable": false,
														                "bSortable": false
														            },
									            					{// Codigo
									            						"aTargets": [3],
														                "bSearchable": true,
														                "bSortable": false
														            },
														            {// Descripcion
									            						"aTargets": [4],
														                "bSearchable": true,
														                "bSortable": false
														            },
														            {// Tipo
									            						"aTargets": [5],
														                "bSearchable": true,
														                "bSortable": false
														            },
														            {// Moneda
									            						"aTargets": [6],
														                "bSearchable": true,
														                "bSortable": false
														            },
														            {// Precio unitario
									            						"aTargets": [7],
														                "bSearchable": false,
														                "bSortable": false
														            },
														            {// Cantidad
									            						"aTargets": [8],
														                "bSearchable": false,
														                "bSortable": false
														            },
														            {// Sub total
									            						"aTargets": [9],
														                "bSearchable": false,
														                "bSortable": false
														            },
														            {// Acciones
									            						"aTargets": [10],
														                "bSearchable": false,
														                "bSortable": false,
														                "fnCreatedCell": function ( cell ) {
														                	$('button', cell).on('click', function(e) {

														                		var _cmd 		= $(this).data('cmd');
														                		var _orderId 	= $(this).data('oid');
														                		var _itemId 	= $(this).data('iid');
														                		var _utype 		= $(this).data('utype');
														                		var _currency	= $(this).data('currency');
														                		var _lang		= $(this).data('lang');
														                		var _uid		= $(this).data('uid');
														                		var _trid 		= $(this).data('trid');
														                		var _this 		= $(this);

														                		if(_cmd=='del') {

														                			var _confirm = confirm('Realmente desea eliminar el articulo seleccionado?');

														                			if(_confirm==true) {
														                				$.d3POST('/customer/orders/detail/item/del',{order_id:_orderId, item_id:_itemId},function(data){

																                			if(data.status==true) {

																                				$.bootstrapGrowl(data.message, {
																			                        type: "success",
																			                        delay: 4500,
																			                        allow_dismiss: true
																			                    });

																			                    $('tr[id="_oid_' + _itemId + '"]',_table).remove();
																			                    _dataTableOr.dataTable()._fnAjaxUpdate();

																                			} else {
																                				$.bootstrapGrowl(data.message, {
																			                        type: "danger",
																			                        delay: 4500,
																			                        allow_dismiss: true
																			                    });
																                			}
																                		});
														                			}

														                		} else if(_cmd='edit') {
														                			
														                			var _form 	= $('#form-item-replace');

														                			$('#order_id',_form).val(_orderId);
														                			$('#o_item_id',_form).val(_itemId);
														                			$('#utype_id',_form).val(_utype);
														                			$('#currency',_form).val(_currency);
														                			$('#lang',_form).val(_lang);
														                			$('#uid',_form).val(_uid);
														                			$('#trid',_form).val(_trid);

														                			$('#modal-order-item-edit').modal('show');
														                		}

														                	});
														                }
														            }
									            				],
									            "order": [ 0, 'desc' ],
									            "iDisplayLength": 5,
									            "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todo"]]
									        });

							var _form = $('#form-additional-data');

							$('#payment-type',_form).val(data.order.payment_type_id);
							$('#payment-data',_form).val(data.order.payment_detail);

							if(data.order.notes.length>0) {
								$.replyHandler(data.order.notes);
							}

							if(_show_modal!=undefined && _show_modal==true) {
								$('span.moie').html(_oid);
								$('#modal-order-view').modal('show');
							}

        				} else {
        					$.bootstrapGrowl('Esta orden no contiene articulos', {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
        				}

        			} else {
        				$.bootstrapGrowl(data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
        			}
        		});

			};

			$('button.btn-reply-save').click(function(e){

				var _form 	= $('#form-chat-data');
				var _nid 	= $('#note_id').val();
				var _reply 	= $('#reply-to-note').val();

				if(_reply=='') {
					$.bootstrapGrowl('Ingrese una respuesta', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}

				$.d3POST('/customer/orders/note/reply',{note_id:_nid,reply:_reply},function(data){

					if(data.status==true) {
						$.bootstrapGrowl(data.message, {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
	                    $('#form-chat-data').trigger('reset');
						$('.reply-container').css('display','none');
						$.replyHandler(data.notes);
					} else {
						$.bootstrapGrowl(data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
					}
				});

				e.preventDefault();
			});

			$('button.btn-reply-cancel').click(function(e){
				$('#form-chat-data').trigger('reset');
				$('.reply-container').css('display','none');
				e.preventDefault();
			});

			$.replyHandler = function(notes) {

				$('.timeline-list').empty();

				var _itmtl = '';

				$.each(notes, function(i,item){

					_itmtl += '<li class="active">';
                    _itmtl += '    <div class="timeline-icon"><i class="gi gi-user"></i></div>';
                    _itmtl += '    <div class="timeline-time">' + item.created_at + '</div>';
                    _itmtl += '    <div class="timeline-content">';
                    _itmtl += '        <p class="push-bit"><strong>' + item.user.name + ' ' + item.user.first_name + ' ' + item.user.last_name + '</strong></p>';
                    _itmtl += '        ' + item.text;
                    (item.reply==null? _itmtl += '<p><button class="btn btn-xs btn-primary pull-left btn-note-reply" data-nid="' + item.id + '">Contestar</button></p>' : '');
                    _itmtl += '    </div>';
                    _itmtl += '</li>';

                    if(item.reply!=null) {
                    	_itmtl += '<li>';
                        _itmtl += '    <div class="timeline-icon"><i class="gi gi-old_man"></i></div>';
                        _itmtl += '    <div class="timeline-time">' + item.reply.created_at + '</div>';
                        _itmtl += '    <div class="timeline-content">';
                        _itmtl += '        <p class="push-bit"><strong>' + item.reply.admin.name + '</strong></p>';
                        _itmtl += '        ' + item.reply.text;
                        _itmtl += '    </div>';
                        _itmtl += '</li>';
                    }

				});

				$('.timeline-list').append(_itmtl);

				$(".mh-chat").animate({ scrollTop: $('.mh-chat')[0].scrollHeight}, 1000);

				$('button.btn-note-reply').click(function(e){

					var _form 		= $('#form-chat-data');
					var _note_id 	= $(this).data('nid');

					$('#note_id', _form).val(_note_id);

					$('.reply-container').css('display','block');

					e.preventDefault();
				});

			};

			// Notificacion por correo
			$('.btn-user-notify').click(function(e){

				var _order_id 	= $('#order_id','#form-notify').val();
				var _notify 	= $('#notify','#form-notify').val();

				$(this).prop('disabled',true);
				$('#notify','#form-notify').prop('disabled',true);

				$.d3POST('/customer/orders/notify',{order:_order_id,message:_notify},function(data){
					if(data.status==true) {
						$.bootstrapGrowl(data.message, {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
	                    $('.btn-user-notify').prop('disabled',true);
	                    $('#notify','#form-notify').prop('disabled',false);
	                    $('#modal-order-notify').modal('hide');
					} else {
						$.bootstrapGrowl(data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
	                    $('.btn-user-notify').prop('disabled',true);
	                    $('#notify','#form-notify').prop('disabled',false);
					}
				});

				e.preventDefault();
			});

			// Redimencion de dialogo??
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

				var target = $(e.target).attr("href") // activated tab

				if(target=='#items') {
					if(!$('#modal-order-view').hasClass('modal-wide')) $('#modal-order-view').addClass('modal-wide');
					//$('.btn-print').prop('disabled',true);
					$('.btn-save').prop('disabled',true);
					$('.btn-reply').prop('disabled',true);
				} else if(target=='#extras' || target=='#reply') {
					
					if($('#modal-order-view').hasClass('modal-wide')) $('#modal-order-view').removeClass('modal-wide');
					
					if(target=='#reply') {
						$('.btn-reply').prop('disabled',false);
						$('.btn-save').prop('disabled',true);
						$('.btn-print').prop('disabled',true);
					} else {
						$('.btn-reply').prop('disabled',true);
						$('.btn-save').prop('disabled',false);
						$('.btn-print').prop('disabled',false);
					}

				}

			});

			$('.btn-save').click(function(){

				var _form 			= $('#form-additional-data');
				var _order_id 		= $('#order_id', _form).val();
				var _payment_type 	= $('#payment-type', _form).val();
				var _payment_data 	= $('#payment-data', _form).val();

				if(_payment_type==0) {
					$.bootstrapGrowl('Seleccione al menos un metodo de pago', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
					return false;
				}

				if(_payment_data=='') {
					$.bootstrapGrowl('Ingrese informacion en el campo de nota', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
					return false;
				}

				$.d3POST('/customer/orders/aditional',{order_id:_order_id, payment_type:_payment_type,payment_data:_payment_data},function(data){
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

			});

			$('.btn-print').click(function(e){
				
				var order_id = $('#order_id','#form-additional-data').val();

				$('<div/>',{id: 'frame_container'}).css('display','none').appendTo('body');
				$("#frame_container").html("<iframe id='printframe' name='printme' src='/print/order/" + order_id + "' />");
				$("#printframe").load( 
                    function() {
                        window.frames['printme'].focus();
                        window.frames['printme'].print();
                    }
                 );

				e.preventDefault();
			});

 		}
 	}

 }();