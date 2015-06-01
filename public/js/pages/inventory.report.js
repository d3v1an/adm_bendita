var InventoryReportData = function() {

 	return {

 		load: function() {

 			var categories = [$("#categories", "#form-detail"),$("#categories", "#form-edit-detail")];
 			$.loadCategories(categories, undefined, true);

 			var complex_categories = [$("#multi-sub-categories", "#form-detail"),$("#e-multi-sub-categories", "#form-edit-detail")];
 			$.loadComplexCategories(complex_categories);

 			var materials = [$("#materials", "#form-extras"),$("#e-materials", "#form-edit-extras")];
 			$.loadMaterials(materials);

 			var sizes = [$("#sizes", "#form-extras"), $("#e-sizes", "#form-edit-extras")];
 			$.loadSizes(sizes);

 			var colors = [$("#colors", "#form-extras"),$("#e-colors", "#form-edit-extras")];
 			$.loadColors(colors);
 		},

 		init: function() {

 			// Definimos el tipo de cambio
 			var _type_change = 0;

 			$.d3POST('/products/inventory/type_change',{},function(data){
				if(data.status==true) _type_change = data.exchange;
			});

			// Codigo de producto global
			var _pcode 		= '';
			var _ppid 		= 0;
			var _pcat 		= 0;

			var imgToUpList 		= [];
			var imgToUpObjs 		= [];
			var mainImgName			= null;
			var itemLinkId 			= 0;
			var btnImgObject		= undefined;

			// Contenedores de botones para deshabilitar
			var packBtnDel 			= [];
			var packBtnMain 		= [];

			// Botones de carga de imagenes en modo actualizacion
			var packUpBtnDel 		= [];
			var packUpBtnMain 		= [];

			// Listas de productos relacionados
			var relColorCodeList 	= [];
            var relColorCodeObjs	= [];

            var _relList 			= [];
            var _relObjs			= [];

            // Limitador de carga segun las imagenes ya ligadas
            var dropUpLimit 		= 10;

 			// Inicializacion de dataTables
 			App.datatables();

 			// Tabla de detalle
 			var _dataTableOi = undefined;//$('.table-order-detail').dataTable();

 			/* Initialize Datatables */
	        var _dataTableOr = $('.table-inventory-report').dataTable({
						            "bProcessing": true,
							        "bServerSide": true,
							        "sAjaxSource" : "/products/inventory/search",
							        "columns" : [
							            { "data": "id" },
							            { "data": null },
							            { "data": "code" },
							            { "data": "category_id" },
							            { "data": "sub_category_id" },
							            { "data": "description" },
							            { "data": "price_public" },
							            { "data": "price_half_wholesale" },
							            { "data": "price_wholesale" },
							            { "data": "price_dealer" },
							            { "data": "status" },
							            { "data": null }
							        ],
						            "aoColumnDefs": [
						            					{// # ID
						            						"aTargets": [0],
											                "bSearchable": false,
											                "bSortable": true
											            },
						            					{// Pic
						            						"aTargets": [1],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {
											                    return '<img src="' + full.url + full.code + '_tumb.jpg" alt="avatar" class="img-thumbnail">';
											                },
											            },
											            {// Code
						            						"aTargets": [2],
											                "bSearchable": true,
											                "bSortable": true
											            },
											            {// Categoria
						            						"aTargets": [3],
											                "bSearchable": true,
											                "bSortable": true,
											                "mRender": function (data, type, full) {
											                    return full.category_name;
											                }
											            },
											            {// Sub Categoria
						            						"aTargets": [4],
											                "bSearchable": true,
											                "bSortable": false,
											                "mRender": function (data, type, full) {
											                    return full.sub_category_name;
											                }
											            },
											            {// # Descripcion
						            						"aTargets": [5],
											                "bSearchable": true,
											                "bSortable": false
											            },
											            {// Precio Publico
						            						"aTargets": [6],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {
											                	var _pp = '$' + full.price_public + ' MXN<br/>$' +full.price_public_usd + ' USD';
											                    return _pp;
											                }
											            },
											            {// Perio medio mayoreo
						            						"aTargets": [7],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {
											                	var _pmm = '$' + full.price_half_wholesale + ' MXN<br/>$' +full.price_half_wholesale_usd + ' USD';
											                    return _pmm;
											                }
											            },
											            {// Precio mayoreo
						            						"aTargets": [8],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {
											                	var _pm = '$' + full.price_wholesale + ' MXN<br/>$' +full.price_wholesale_usd + ' USD';
											                    return _pm;
											                }
											            },
											            {// Precio distribuidor
						            						"aTargets": [9],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {
											                	var _pm = '$' + full.price_dealer + ' MXN<br/>$' +full.price_dealer_usd + ' USD';
											                    return _pm;
											                }
											            },
											            {// Estatus
						            						"aTargets": [10],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _select  = '<select id="status" name="status" data-id="' + full.id + '">';
											                		_select += '	<option value="1" ' + (full.status==1?'selected':'') + '>Activo</option>';
											                		_select += '	<option value="0" ' + (full.status==0?'selected':'') + '>Inactivo</option>';
							                                    	_select += '</select>';

											                    return _select;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('select', cell).on('change', function(e) {

											                		var _item_id		= $(this).data('id');
											                		var _item_status	= $(this).val();

											                		$.d3POST('/products/inventory/item/status',{id:_item_id,status:_item_status},function(data){
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

											                	})
											                }
											            },
											            {// Acciones
						            						"aTargets": [11],
											                "bSearchable": false,
											                "bSortable": false,
											                "mRender": function (data, type, full) {

											                	var _buttons  = '<div class="btn-group btn-group-xsm">';
											                		_buttons += '	<button class="btn btn-xs btn-default" data-cmd="view" data-id="' + full.id + '"><i class="gi gi-eye_open"></i></button>';
											                		_buttons += '	<button class="btn btn-xs btn-default" data-cmd="edit" data-id="' + full.id + '"><i class="gi gi-pencil"></i></button>';
											                		_buttons += '</div>';

											                    return _buttons;
											                },
											                "fnCreatedCell": function ( cell ) {
											                	$('button', cell).on('click', function(e) {

											                		var _cmd = $(this).data('cmd');
											                		var _pid = $(this).data('id');

											                		if(_cmd=='view') {

											                			$.d3POST('/products/inventory/item/info',{id:_pid},function(data){
																			if(data.status==true) {

																				$("#widget-carousel1").carousel("pause").removeData();

																				// Titulo de dialogo
																				$('.mdl-product-code').html(data.product.code);

																				// Link
																				$('a.wid-item-link').prop('href', url + '/' + data.product.category.tag + '/' + data.product.sub_category.tag + '/' + data.product.link.url );

																				// Limpiamos la galeria
																				$('.wid-item-gallery').html('');

																				// Agregamos la imagen principal
																				var _main_img  = '<div class="active item">';
																					_main_img += '	<img src="' + url + img_cat + data.product.code + '.jpg" alt="image">';
																					_main_img += '</div>';

																				$('.wid-item-gallery').append(_main_img);

																				// Agregamos las imagenes adicionales
																				if(data.product.galery.length>0) {
																					$.each(data.product.galery,function(i, item){
																						var _sub_img  = '<div class="item">';
																							_sub_img += '	<img src="' + url + img_cat + item.image + '" alt="image">';
																							_sub_img += '</div>';
																						$('.wid-item-gallery').append(_sub_img);
																					});
																				}

																				$("#widget-carousel1").carousel(0);

																				// Bio de oroducto
																				$('.wid-item-code').html(data.product.code);
																				$('.wid-item-stock').html(data.product.stock);
																				$('.wid-item-category').html(data.product.category.name + ' / ' + data.product.sub_category.name);
																				$('.wid-item-description').html(data.product.description);
																				$('.wid-item-detail').html(data.product.detail);

																				// Materiales
																				if(data.product.materials.length>0) {
																					var _materials = '';
																					$.each(data.product.materials,function(i, item){
																						_materials += '<a href="javascript:void(0)" class="label label-info">' + item.name + '</a> ';
																					});
																					$('.wid-item-materials').html(_materials);
																				}

																				// Colores
																				if(data.product.colors.length>0) {
																					var _colors = '';
																					$.each(data.product.colors,function(i, item){
																						_colors += '<a href="javascript:void(0)" class="label" style="background-color:#FF00EE!important">' + item.name + '</a> ';
																					});
																					$('.wid-item-colors').html(_colors);
																				}

																				var _pp 		= '$' + parseInt(data.product.price_public).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' MXN / ';
																				var _pp_usd 	= '$' + parseInt(data.product.price_public_usd).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' USD';
																				var _p_pp 		= _pp + ' ' + _pp_usd;
																				$('.wid-item-p-public').html(_p_pp);

																				var _phw 		= '$' + parseInt(data.product.price_half_wholesale).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' MXN / ';
																				var _phw_usd 	= '$' + parseInt(data.product.price_half_wholesale_usd).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' USD';
																				var _p_phw 		= _phw + ' ' + _phw_usd;
																				$('.wid-item-p-half-wholesale').html(_p_phw);

																				var _pw 		= '$' + parseInt(data.product.price_wholesale).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' MXN / ';
																				var _pw_usd 	= '$' + parseInt(data.product.price_wholesale_usd).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' USD';
																				var _p_pw 		= _pw + ' ' + _pw_usd;
																				$('.wid-item-p-wholesale').html(_p_pw);

																				var _pd 		= '$' + parseInt(data.product.price_dealer).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' MXN / ';
																				var _pd_usd 	= '$' + parseInt(data.product.price_dealer_usd).toFixed(2).replace(/./g, function(c, i, a) { return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;}) + ' USD';
																				var _p_pd 		= _pd + ' ' + _pd_usd;
																				$('.wid-item-p-dealer').html(_p_pd);

												                				$('#modal-product-view').modal('show');

												                			} else {
												                				$.bootstrapGrowl(data.message, {
															                        type: "danger",
															                        delay: 4500,
															                        allow_dismiss: true
															                    });
												                			}
																		});
											                			
											                		} else if(_cmd=='edit') {

											                			$.d3POST('/products/inventory/item/info',{id:_pid},function(data){

											                				if(data.status==true) {	

											                					// Carga de imagenes
											                					$('#existing-images').empty();

											                					imgToUpObjs 		= [];
											                					imgToUpList 		= [];

											                					packUpBtnDel 		= [];
											                					packUpBtnMain 		= [];

											                					var _pid 			= data.product.id;

											                					var itmName 		= '';
											                					var imgData 		= {};

											                					var _objImage 		= '';

											                					var _this_btn_del 	= undefined;
										                                    	var _this_btn_main 	= undefined;

											                					// Cargamos la imagen principal por defecto
											                					_mimage 			= data.product.code + '.jpg';
											                                    itmName 			= CryptoJS.MD5(_mimage).toString();
																				imgData 			= {  "name" : _mimage , "hash" : itmName, 'isMain' : true };

										                						_objImage += '<div id="_e_img_' + itmName + '" class="galery-up-file btns-uploaded">';
										                                        _objImage += '	<div><span class="preview"><img class="img-responsive center-block uploaded" src="' + url + img_cat + data.product.code + '_cat.jpg" /></span></div>';
										                                        _objImage += '	<div>';
										                                        _objImage += '		<div class="btn-group">';
										                                        _objImage += '			<button class="btn btn-xs btn-default" id="_e_d_' + itmName + '" data-hash="' + itmName + '" data-pid="' + _pid + '" data-mig="' + data.product.id + '" data-cmd="del" type="button"><i class="gi gi-bin"></i> Eliminar</button>';
										                                        _objImage += '			<button class="btn btn-xs btn-danger" id="_e_e_' + itmName + '" data-hash="' + itmName + '" data-pid="' + _pid + '" data-mig="' + data.product.id + '" data-cmd="pic" type="button"><i class="gi gi-heart"></i> Principal</button>';
										                                        _objImage += '		</div>';
										                                        _objImage += '	</div>';
										                                    	_objImage += '</div>';

										                                    	$('#existing-images').append(_objImage);

										                                    	_this_btn_del 		= $("button#_e_d_" + itmName, ".btns-uploaded");
										                                    	_this_btn_main 		= $("button#_e_e_" + itmName, ".btns-uploaded");

										                                    	packUpBtnDel.push(_this_btn_del);
										                                    	packUpBtnMain.push(_this_btn_main);

																				imgToUpObjs.push(imgData);
																				imgToUpList.push(itmName);

																				// Decrementamos la cantidad de imagenes a cargar para actualizar
																				dropUpLimit = ((dropUpLimit - 1) - data.product.galery.length);

																				_e_dz.options.maxFiles 			= dropUpLimit;
																				_e_dz.options.parallelUploads 	= dropUpLimit;

																				btnImgObject 		= _this_btn_main;
																				mainImgName 		= itmName;

																				_objImage 			= '';

											                                    // Cargamos la galeria adjunta cuando existe
											                                    if(data.product.galery.length > 0) {

											                                    	$.each(data.product.galery, function(i, item){

											                                    		itmName = CryptoJS.MD5(item.image).toString();
																						imgData = {  "name" : item.image , "hash" : itmName, 'isMain' : false };

										                                    			_objImage = '<div id="_e_img_' + itmName + '" class="galery-up-file btns-uploaded">';
												                                        _objImage += '	<div><span class="preview"><img class="img-responsive center-block uploaded" src="' + url + img_cat + item.image + '" /></span></div>';
												                                        _objImage += '	<div>';
												                                        _objImage += '		<div class="btn-group">';
												                                        _objImage += '			<button class="btn btn-xs btn-default" id="_e_d_' + itmName + '" data-hash="' + itmName + '" data-pid="' + _pid + '" data-mig="' + item.id + '" data-cmd="del" type="button"><i class="gi gi-bin"></i> Eliminar</button>';
												                                        _objImage += '			<button class="btn btn-xs btn-success" id="_e_e_' + itmName + '" data-hash="' + itmName + '" data-pid="' + _pid + '" data-mig="' + item.id + '" data-cmd="pic" type="button"><i class="gi gi-heart"></i> Principal</button>';
												                                        _objImage += '		</div>';
												                                        _objImage += '	</div>';
												                                    	_objImage += '</div>';

												                                    	$('#existing-images').append(_objImage);

												                                    	_this_btn_del 	= $("button#_e_d_" + itmName, ".btns-uploaded");
												                                    	_this_btn_main 	= $("button#_e_e_" + itmName, ".btns-uploaded");

												                                    	packUpBtnDel.push(_this_btn_del);
												                                    	packUpBtnMain.push(_this_btn_main);

																						imgToUpObjs.push(imgData);
																						imgToUpList.push(itmName);									                                    	

											                                    	});

											                                    }

																				$("button", ".btns-uploaded").on('click', function(){

																					var _cmd 	= $(this).data('cmd');
																					var _hash 	= $(this).data('hash');
																					var _ppid 	= $(this).data('pid');
																					var _mid 	= $(this).data('mig');

																					if(_cmd=='del') {

																						if(mainImgName==_hash) {
																							$.bootstrapGrowl('No puedes eliminar la imagen principal.', {
																		                        type: "danger",
																		                        delay: 4500,
																		                        allow_dismiss: true
																		                    });
																							return false;
																						}
																							
																						imgToUpList.splice(imgToUpList.indexOf(_hash), 1);

																						$.each(imgToUpObjs, function(i, item){
																							if(item.has==_hash) {
																								imgToUpObjs.splice(imgToUpObjs.indexOf(item), 1);
																								return false;
																							}
																						});

																						dropUpLimit = (dropUpLimit + 1);

																						_e_dz.options.maxFiles 			= dropUpLimit;
																						_e_dz.options.parallelUploads 	= dropUpLimit;

																						$('#existing-images div[id="_e_img_' + _hash + '"]').remove();

																					} else if(_cmd=='pic') {

																						btnImgObject.removeClass('btn-danger');
																						btnImgObject.addClass('btn-success');

																						$.each(imgToUpObjs, function(i, item){
																							if(item.hash=_hash) item.isMain = true;
																							else item.isMain = false;
																						});

																						btnImgObject 		= $(this);
																						mainImgName 		= _hash;

																						btnImgObject.removeClass('btn-success');
																						btnImgObject.addClass('btn-danger');

																					}
																					
																					console.log(packUpBtnDel);
																					console.log(packUpBtnMain);
																				});

											                					// Detalle
											                					var _form = $("#form-edit-detail");

											                					$("#pid", _form).val(_pid);
											                					$("#code", _form).val(data.product.code);
											                					$("#stock", _form).val(data.product.stock);
											                					$("#title", _form).val(data.product.description);
											                					$("#title-eng", _form).val(data.product.description_en);
											                					
											                					CKEDITOR.instances["e_description"].setData(data.product.detail);
											                					CKEDITOR.instances["e_description-eng"].setData(data.product.detail_en);

											                					$("#categories", _form).val(data.product.category_id);

											                					var e_sub_categories = $("#sub-categories", _form);
 																				$.loadSubCategories(e_sub_categories, data.product.category_id, data.product.sub_category_id);

 																				$("#e-multi-sub-categories option").prop("selected", false);
 																				if(data.product.sub_categories.length > 0) {
 																					$.each(data.product.sub_categories, function(i, item){
 																						$("#e-multi-sub-categories option[value='" + item.id + "']").prop("selected", true);
 																					});
 																				}

 																				$("#price_public", _form).val(data.product.price_public);
 																				$("#price_public_usd", _form).val(data.product.price_public_usd);
 																				$("#price_half_wholesale", _form).val(data.product.price_half_wholesale);
 																				$("#price_half_wholesale_usd", _form).val(data.product.price_half_wholesale_usd);
 																				$("#price_wholesale", _form).val(data.product.price_wholesale);
 																				$("#price_wholesale_usd", _form).val(data.product.price_wholesale_usd);
 																				$("#price_dealer", _form).val(data.product.price_dealer);
 																				$("#price_dealer_usd", _form).val(data.product.price_dealer_usd);

 																				$("#gender", _form).val(data.product.gender);

 																				// Relations
 																				var _table = $("table.table-edit-relations");
 																				
 																				$('tbody',_table).empty();

 																				_relList = [];
																	            _relObjs = [];

 																				if(data.product.products.length > 0) {
 																					
 																					var _tr 	= '';

																					$.each(data.product.products, function(i, item){

																						_tr 	+= '<tr id="' + item.product.code + '">';
																	            		_tr 	+= '	<td class="text-center"><img src="' + url + img_cat + item.product.code + '_tumb.jpg" width="50" height="50" /></td>';
																	            		_tr 	+= '	<td>' + item.product.code + '</td>';
																	            		_tr 	+= '	<td>' + item.product.description + '</td>';
																	            		_tr 	+= '	<td class="text-center">';
																	            		_tr 	+= '		<div class="btn-group">';
																	            		_tr 	+= '			<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" class="btn btn-xs btn-danger btn-del" id="_e_a_' + item.product.code + '" data-code="' + item.product.code + '"><i class="fa fa-times"></i></a>';
																	            		_tr 	+= '		</div>';
																	            		_tr 	+= '	</td>';
																	            		_tr 	+= '</tr>';

																	            		var relObj = {
																		            		'id' 	: item.product.id,
																		            		'code'	: item.product.code,
																		            		'desc'	: item.product.description
																		            	};

																		            	_relList.push(item.product.code);
																		            	_relObjs.push(relObj);

																					});

																					_table.append(_tr);

																					// Acion para eliminar un elemnto relacional
																	            	$('tbody tr td div a', _table).on('click', function() {

																	            		var _confirm = confirm('Realmente dese eliminar este articulo de la lista de relaciones?');

																	            		if(_confirm==true) {

																	            			var _code = $(this).data('code');

																		            		_relList.splice(_relList.indexOf(_code), 1);

																		            		$.each(_relObjs, function(i, item) {
																		    					if(item.code == _code) {
																		    						_relObjs.splice(_relObjs.indexOf(item), 1);
																		    						return false;
																		    					}
																		    				});

																		    				$('tbody tr[id="' + _code + '"]', _table).remove();

																	            		}

																	            	});

 																				}

 																				// Extras
 																				$("#e-materials option").prop("selected", false);
 																				if(data.product.materials.length > 0) {
 																					$.each(data.product.materials, function(i, item){
 																						$("#e-materials option[value='" + item.id + "']").prop("selected", true);
 																					});
 																				}
 																				$("#e-sizes option").prop("selected", false);
 																				if(data.product.sizes.length > 0) {
 																					$.each(data.product.materials, function(i, item){
 																						$("#e-sizes option[value='" + item.id + "']").prop("selected", true);
 																					});
 																				}

 																				relColorCodeList = [];
            																	relColorCodeObjs = [];

            																	$("#e-link-color option").empty();
 																				if(data.product.link_colors.length > 0) {
 																					
 																					var _osel = '';
 																					
 																					$.each(data.product.link_colors, function(i, item){

 																						var relObj = {
																		            		'color_id' 	: item.color_id,
																		            		'item_id'	: item.product_id,
																		            		'item_code'	: item.product.code,
																		            		'item_desc'	: item.product.description
																		            	};

																		            	relColorCodeList.push(item.color_id);
            																			relColorCodeObjs.push(relObj);

 																						_osel += '<option value="' + item.color_id + '|' + item.product_id + '" data-cid="' + item.color_id + '">' + item.color.name + ' - ' + item.product.code + ' - ' + item.product.description + '</option>';
 																					});

 																					$("#e-link-color","#form-edit-extras").append(_osel);

 																					$("#e-link-color","#form-edit-extras").on('dblclick', function(){

 																						var _selected 	= $('option:selected',this);
 																						var _color_id 	= _selected.data('cid');

 																						if(_selected.length>0) {

 																							var _confirm 	= confirm('Realmente desea eliminar el item "' + _selected.text() + '"?');

	 																						if(_confirm==true) {

	 																							$.each(relColorCodeObjs, function(y, ytem){
	 																								console.log(ytem.color_id + '-' + _color_id);
	 																								if(ytem.color_id==_color_id) {
	 																									relColorCodeObjs.splice(relColorCodeObjs.indexOf(ytem), 1);
	 																									return false;
	 																								}
	 																							});

	 																							relColorCodeList.splice(relColorCodeList.indexOf(_color_id), 1);
	 																							_selected.remove();
	 																						}
 																						}
 																						
 																					});
 																				}

											                					$('#modal-edit-product').modal('show');
											                				}
											                				else {

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
						            				],
						            "order": [ 0, 'desc' ],
						            "iDisplayLength": 10,
						            "aLengthMenu": [[10, 20, 30], [10, 20, 30]]
						        });

	        /* Add placeholder attribute to the search input */
	        $('.dataTables_filter input').attr('placeholder', 'Buscar');

	        // Boton para nuevos productos
	        $('.btn-new-product').click(function(){
	        	$('#modal-add-product').modal('show');
	        });

	        // Boton de categorias
	        $('.btn-categories').click(function(){
	        	$('#modal-categories').modal('show');
	        });

	        // Boton de sub categorias
	        $('.btn-sub-categories').click(function(){
	        	$('#modal-sub-categories').modal('show');
	        });

	        // Boton de colores
	        $('.btn-colors').click(function(){
	        	$('#modal-colors').modal('show');
	        });

	        // Boton de materiales
	        $('.btn-materials').click(function(){
	        	$('#modal-materials').modal('show');
	        });

	        // Boton de tallas
	        $('.btn-sizes').click(function(){
	        	$('#modal-sizes').modal('show');
	        });

	        // Dropzone

	        // Disable auto discover for all elements:
    		Dropzone.autoDiscover	= false;
    		var dropLimit 			= 10;

    		var previewNode 		= document.querySelector("#template");
			previewNode.id 			= "";
			var previewTemplate 	= previewNode.parentNode.innerHTML;
			previewNode.parentNode.removeChild(previewNode);

			// Listado de imagenes a cargar y su configuracion adicional
    		var _dz = new Dropzone("div#dropzone",{ // Configuracion inicial de dropzone
		        url: "/media/image/upload",
		        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><p><span>Arrastra tu imagen ó da click.</span></p>',
		        autoProcessQueue: false,
		        uploadMultiple: false,
		        parallelUploads: dropLimit, 
		        maxFiles: dropLimit,
		        maxFilesize: 15, // 5MB
		        
		        thumbnailWidth:150,
        		thumbnailHeight:225,
        		
        		previewTemplate: previewTemplate,
		        previewsContainer: "#previews",

		        dictFileTooBig: 'tb:La imagen es demasiado grande',
		        acceptedFiles: 'image/jpeg,image/jpg',
		        dictInvalidFileType: 'uf:Archivo no soportado',

		        maxfilesexceeded: function(file) { // Si se excede el numero de archivos se remueven los que esten agregados de mas de la dropzone
		            $.bootstrapGrowl('Ha superado el número máximo de imágenes a cargar.', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
		            this.removeFile(file);
		        },
		        error: function(file, response) { // SI existe un error este los mostramos
		            if($.type(response) === "string") {
		                var err = response.split(':');
		                if(err[0]=='tb') {
		                    $.bootstrapGrowl(file.name + ' ' + err[1], {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
		                    this.removeFile(file);
		                } else if(err[0]=='uf') {
		                    $.bootstrapGrowl(file.name + ' ' + err[1], {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
		                    this.removeFile(file);
		                }
		            }
		        },
		        sending: function(file, xhr, formData) { // Se agrega informacion adicional a la carga de imagenes

		        	var itmHash = CryptoJS.MD5(file.name).toString();
		        	var isMain 	= false;

		        	$.each(imgToUpObjs, function(i, itm) {
						if(itm.hash == itmHash) isMain = itm.isMain;
					});

		        	formData.append('pid', _ppid);
		        	formData.append('category', _pcat);
		        	formData.append('code', _pcode);
		        	formData.append('name', file.name);
		        	formData.append('hash', itmHash);
		        	formData.append('is_main', isMain);

		        },
		        accept: function(file, done) { // Si la imagen es acpetable se configura la  previsualizacion y sus botones

		        	done();

		        	var preview = $(file.previewTemplate);

		        	var _qfiles = this.getQueuedFiles();

		        	var _this 	= this;

		        	$.each(_qfiles, function(i, item) {

		        		var itmName = CryptoJS.MD5(item.name).toString();
		        		var imgData = {  "name" : item.name , "hash" : itmName, 'isMain' : false };

		        		if($.inArray(itmName, imgToUpList)==-1) {

		        			imgToUpObjs.push(imgData);
		        			imgToUpList.push(itmName);

		        			var btn_pic 		= preview.find('.btn-pic');
		        			var btn_del 		= preview.find('.btn-del');
		        			var obj_progress	= preview.find('.progress-object');

		        			packBtnDel.push(btn_del);
		        			packBtnMain.push(btn_pic);

		        			// Boton de imagen principal
		        			btn_pic.data('cimg', itmName);
		        			btn_pic.data('img', item.name);

		        			btn_pic.on('click', function(e){

		        				mainImgName = $(this).data('cimg');

	        					$(this).removeClass('btn-success');
	        					$(this).addClass('btn-danger');

	        					if(btnImgObject==undefined) btnImgObject = btn_pic;
	        					else {

	        						btnImgObject.removeClass('btn-danger');
	        						btnImgObject.addClass('btn-success');

	        						btnImgObject = btn_pic;
	        					}

	        					$.each(imgToUpObjs, function(i, itm) {
	        						if(itm.hash == mainImgName) itm.isMain = true;
	        						else itm.isMain = false;
	        					});

	        					obj_progress.prop('id', '_p_' + itmName);

		        				e.preventDefault();
		        				e.stopPropagation();
		        			});

		        			// Boton de imagen a eliminar
		        			btn_del.data('cimg', itmName);
		        			btn_del.data('img', item.name);

		        			btn_del.on('click', function(e){

		        				var imgHash = $(this).data('cimg');

		        				if(mainImgName == imgHash) {
		        					$.bootstrapGrowl('La imagen principal no puede ser eliminada', {
				                        type: "danger",
				                        delay: 4500,
				                        allow_dismiss: true
				                    });
		        					return false;
		        				}

		        				_this.removeFile(file);

		        				imgToUpList.splice(imgToUpList.indexOf(imgHash), 1);


		        				$.each(imgToUpObjs, function(i, oitm) {
		        					if(oitm.hash == imgHash) {
		        						imgToUpObjs.splice(imgToUpObjs.indexOf(oitm), 1);
		        						return false;
		        					}
		        				});

		        				e.preventDefault();
		        				e.stopPropagation();
		        			});
		        		}

		        	});

		        },
		        complete: function(file) { // Una ves completada la carga ... [Pendinete]

		        	if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

		        		// Mensaje de finalizacion de carga de producto
						$.bootstrapGrowl('Carga de producto exitosa', {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });

	                    // Ocultamos el modal
	                    $('#modal-add-product').modal('hide');
			        }

			        if(file.status=='success') {
			        	var _data           = $.parseJSON(file.xhr.response);
						//console.log(_data);
			        }

		        }
		    });

			// Detalle - Codigo
			$('#code','#form-detail').on('keypress keyup',function(e){
				this.value = this.value.toUpperCase();
			});
			$('#code','#form-detail').on('focusout',function(e){

				$(this).val().toUpperCase();

				var code 	= $(this).val();
				
				$.d3POST('/products/code/search',{code:code},function(data){
					if(data.status==true) {
						$.bootstrapGrowl(data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
	                    $('#code','#form-detail').focus();
	                    $('#code','#form-detail').select();
					}
				});

			});

			// Stock
			$('#stock','#form-detail').on('keypress keyup',function(e){
				
				if(!$.isNumeric($(this).val())) {
					
					$.bootstrapGrowl('Solo se admiten numeros', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });

                    $(this).val(0);
                    $(this).select();

                    return false;
				}

				if(parseInt($(this).val()) < 0) {
					$.bootstrapGrowl('No e admiten numeros negativos', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
				}
			});

			// Categorias
			$('#categories','#form-detail').on('change', function(){
				var sub_categories = $("#sub-categories");
 				if(parseInt($(this).val())>0) $.loadSubCategories(sub_categories, $(this).val());
			});

			// Autocomplete de relations
            var _form 		= $('#form-relations')
            var $input 		= $('#code', _form);
            var _table 		= $('table#relations-datatable');

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
            		$(".btn-search-code", _form).prop('disabled', false);
            		return item.code + ' (' + item.description + ')';
            	}
            });

            $(".btn-search-code", _form).click(function(){

            	var data 	= $input.typeahead("getActive");
            	var _id 	= data.id;
            	var _code 	= data.code;
            	var _desc 	= data.description.trim();

            	if($.inArray(_code, _relList) > -1) {
            		$.bootstrapGrowl('El articulo ya se encuentra relacionado', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
            		return false;
            	}

            	var _tr 	= '<tr id="' + _code + '">';
            		_tr 	+= '	<td class="text-center"><img src="' + url + img_cat + _code + '_tumb.jpg" width="50" height="50" /></td>';
            		_tr 	+= '	<td>' + _code + '</td>';
            		_tr 	+= '	<td>' + _desc + '</td>';
            		_tr 	+= '	<td class="text-center">';
            		_tr 	+= '		<div class="btn-group">';
            		_tr 	+= '			<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" class="btn btn-xs btn-danger btn-del" id="_a_' + _code + '" data-code="' + _code + '"><i class="fa fa-times"></i></a>';
            		_tr 	+= '		</div>';
            		_tr 	+= '	</td>';
            		_tr 	+= '</tr>';

            	$('tbody', _table).append(_tr);

            	// Acion para eliminar un elemnto relacional
            	$('tbody tr td div a[id="_a_' + _code + '"]', _table).on('click', function() {

            		var _confirm = confirm('Realmente dese eliminar este articulo de la lista de relaciones?');

            		if(_confirm==true) {

            			var _code = $(this).data('code');

	            		_relList.splice(_relList.indexOf(_code), 1);

	            		$.each(_relObjs, function(i, item) {
	    					if(item.code == _code) {
	    						_relObjs.splice(_relObjs.indexOf(item), 1);
	    						return false;
	    					}
	    				});

	    				$('tbody tr[id="' + _code + '"]', _table).remove();

            		}

            	});

            	var relObj = {
            		'id' 	: _id,
            		'code'	: _code,
            		'desc'	: _desc
            	};

            	_relList.push(_code);
            	_relObjs.push(relObj);

            	$('#code', '#form-relations').val('');
            	$(".btn-search-code").prop('disabled', true);
            });

			// Dialogo para el enlace de colores y links de productos
			$(".btn-color-link").click(function(){

				var _selected_color = $("#colors option:selected","#form-extras").val();

				if(_selected_color==undefined) {
					$.bootstrapGrowl('Selecione un color primero', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}

				$("#modal-link-color").modal('show');
			});

			// Autocompletado de relacion de colores
            var _e_form 			= $('#form-link-color')
            var $e_input 			= $('#code', _e_form);

            $e_input.typeahead({
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

            $('.btn-select').click(function(){

            	var data 	= $e_input.typeahead("getActive");
            	var _id 	= data.id;
            	var _code 	= data.code;
            	var _desc 	= data.description.trim();
            	var _cid 	= $("#colors option:selected","#form-extras").val();
            	var _ctx 	= $("#colors option:selected","#form-extras").text();

            	if($.inArray(_cid, relColorCodeList) > -1) {
            		$.bootstrapGrowl('El color y el articulo ya se encuentran relacionados', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
            		return false;
            	}

            	var relObj = {
            		'color_id' 	: _cid,
            		'item_id'	: _id,
            		'item_code'	: _code,
            		'item_desc'	: _desc
            	};

            	var _osel = '<option value="' + _cid + '|' + _id + '">' + _ctx + ' - ' + _code + ' - ' + _desc + '</option>';
            	$("#link-color","#form-extras").append(_osel);
            	$("#link-color option","#form-extras").prop('selected', true);

            	relColorCodeList.push(_cid);
            	relColorCodeObjs.push(relObj);

            	$('#modal-link-color').modal('hide');
            });

			// Actualizacion de instancias de CKEditor
			$.CKupdate = function() {
				for ( instance in CKEDITOR.instances ){
			        CKEDITOR.instances[instance].updateElement();
			    }
			    //CKEDITOR.instances[instance].setData('');
			};

			// Prices
			$('#price_public, #price_half_wholesale, #price_wholesale, #price_dealer','#form-detail').on('keypress keyup',function(e){
				
				if($(this).val().length >= 1) {
					if(!$.isNumeric($(this).val())) {
						
						$.bootstrapGrowl('Solo se admiten numeros', {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });

	                    $(this).val(0);
	                    $(this).select();

	                    return false;
					}

					if(parseInt($(this).val()) < 0) {
						$.bootstrapGrowl('No e admiten numeros negativos', {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
					}

					var usd_price	= (Math.ceil(parseInt($(this).val()) / _type_change));
					var cur_id 		= $(this).prop('id');

					if(cur_id=='price_public') $('#price_public_usd').val(usd_price);
					if(cur_id=='price_half_wholesale') $('#price_half_wholesale_usd').val(usd_price);
					if(cur_id=='price_wholesale') $('#price_wholesale_usd').val(usd_price);
					if(cur_id=='price_dealer') $('#price_dealer_usd').val(usd_price);
				}
			});

			// Fix para overmodal
	        $('#modal-add-product').on('hidden.bs.modal', function(e){
                
                $('#form-detail').trigger('reset');
                $("table#elations-datatable tbody").empty();
                $('#form-relations').trigger('reset');
                $('#form-extras').trigger('reset');

                // Formularios
				$(":input", "#form-detail").prop("disabled", false);
				$(":input", "#form-relations").prop("disabled", false);
				$(":input", "#form-extras").prop("disabled", false);

				// Botones
				$("button.btn-upload-product").prop('disabled', false);
				$("button.btn-cancel-product").prop('disabled', false);

				// Limpiamos los textarea instanciados con CKEditor
                CKEDITOR.instances['description'].setData('');
                CKEDITOR.instances['description-eng'].setData('');

                // Limpiamos la tabla de relaciones
                $("table.table-relations tbody").empty();

                // Limpiamos el multiselect de la relacion de colores y productos
                $("#link-color","#form-extras").empty();

                // Limpiamos el combo de sub-categorias
                $("#sub-categories","#form-detail").empty();

                // Reseteamos todas nuestras variables
                // Codigo de producto global
				_pcode 		= '';
				_ppid 		= 0;
				_pcat 		= 0;

				// Listado de imagenes a cargar y su configuracion adicional
				imgToUpList 		= [];
				imgToUpObjs 		= [];
				mainImgName			= null;
				itemLinkId 			= 0;
				btnImgObject		= undefined;

				// Contenedores de botones para deshabilitar
				packBtnDel 			= [];
				packBtnMain 		= [];

				// Lista de productos relacionados
				relColorCodeList 	= [];
	            relColorCodeObjs	= [];
	            _relList 			= [];
	            _relObjs			= []; 

				// Re-iniciamos la dropzone
                _dz.removeAllFiles();

                // Recargamos la tabla
				_dataTableOr.dataTable()._fnAjaxUpdate();
            });

			// Codigo
			// Autocomplete de relations
            var e_form 		= $('#form-edit-relations')
            var $e_input 	= $('#code', e_form);
            var e_table 	= $('table#relations-edit-datatable');

            $e_input.typeahead({
            	source:function(request, response) {

            		var _state 	= $e_input.val();
            		var _term 	= request.term;

					$.d3POST('/customer/orders/detail/item/search',{state:_state, term:_term},function(data){
						response(data);
					});
            	},
            	autoSelect: true,
            	minLength: 2,
            	items:'all',
            	displayText: function(item) {
            		$(".btn-search-code", e_form).prop('disabled', false);
            		return item.code + ' (' + item.description + ')';
            	}
            });

            $(".btn-search-code", e_form).click(function(){

            	var data 	= $e_input.typeahead("getActive");
            	var _id 	= data.id;
            	var _code 	= data.code;
            	var _desc 	= data.description.trim();

            	if($.inArray(_code, _relList) > -1) {
            		$.bootstrapGrowl('El articulo ya se encuentra relacionado', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
            		return false;
            	}

            	var _tr 	= '<tr id="' + _code + '">';
            		_tr 	+= '	<td class="text-center"><img src="' + url + img_cat + _code + '_tumb.jpg" width="50" height="50" /></td>';
            		_tr 	+= '	<td>' + _code + '</td>';
            		_tr 	+= '	<td>' + _desc + '</td>';
            		_tr 	+= '	<td class="text-center">';
            		_tr 	+= '		<div class="btn-group">';
            		_tr 	+= '			<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" class="btn btn-xs btn-danger btn-del" id="_a_' + _code + '" data-code="' + _code + '"><i class="fa fa-times"></i></a>';
            		_tr 	+= '		</div>';
            		_tr 	+= '	</td>';
            		_tr 	+= '</tr>';

            	$('tbody', e_table).append(_tr);

            	// Acion para eliminar un elemnto relacional
            	$('tbody tr td div a[id="_a_' + _code + '"]', e_table).on('click', function() {

            		var _confirm = confirm('Realmente dese eliminar este articulo de la lista de relaciones?');

            		if(_confirm==true) {

            			var _code = $(this).data('code');

	            		_relList.splice(_relList.indexOf(_code), 1);

	            		$.each(_relObjs, function(i, item) {
	    					if(item.code == _code) {
	    						_relObjs.splice(_relObjs.indexOf(item), 1);
	    						return false;
	    					}
	    				});

	    				$('tbody tr[id="' + _code + '"]', e_table).remove();

            		}

            	});

            	var relObj = {
            		'id' 	: _id,
            		'code'	: _code,
            		'desc'	: _desc
            	};

            	_relList.push(_code);
            	_relObjs.push(relObj);

            	$('#code', '#form-edit-relations').val('');
            	$(".btn-search-code", e_form).prop('disabled', true);
            });

			// Dropzeone de actualizacion
    		var previewNode 		= document.querySelector("#templateUp");
			previewNode.id 			= "";
			var previewTemplate 	= previewNode.parentNode.innerHTML;
			previewNode.parentNode.removeChild(previewNode);

			var _e_dz = new Dropzone("div#e_dropzone",{ // Configuracion inicial de dropzone
		        url: "/media/image/upload",
		        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><p><span>Arrastra tu imagen ó da click.</span></p>',
		        autoProcessQueue: false,
		        uploadMultiple: false,
		        parallelUploads: dropUpLimit, 
		        maxFiles: dropUpLimit,
		        maxFilesize: 15, // 15MB
		        
		        thumbnailWidth:150,
        		thumbnailHeight:225,
        		
        		previewTemplate: previewTemplate,
		        previewsContainer: "#previewsUp",

		        dictFileTooBig: 'tb:La imagen es demasiado grande',
		        acceptedFiles: 'image/jpeg,image/jpg',
		        dictInvalidFileType: 'uf:Archivo no soportado',

		        maxfilesexceeded: function(file) { // Si se excede el numero de archivos se remueven los que esten agregados de mas de la dropzone
		            $.bootstrapGrowl('Ha superado el número máximo de imágenes a cargar.', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
		            this.removeFile(file);
		        },
		        error: function(file, response) { // SI existe un error este los mostramos
		            if($.type(response) === "string") {
		                var err = response.split(':');
		                if(err[0]=='tb') {
		                    $.bootstrapGrowl(file.name + ' ' + err[1], {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
		                    this.removeFile(file);
		                } else if(err[0]=='uf') {
		                    $.bootstrapGrowl(file.name + ' ' + err[1], {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
		                    this.removeFile(file);
		                }
		            }
		        },
		        sending: function(file, xhr, formData) { // Se agrega informacion adicional a la carga de imagenes

		        	/*
		        	var itmHash = CryptoJS.MD5(file.name).toString();
		        	var isMain 	= false;

		        	$.each(imgToUpObjs, function(i, itm) {
						if(itm.hash == itmHash) isMain = itm.isMain;
					});

		        	formData.append('pid', _ppid);
		        	formData.append('category', _pcat);
		        	formData.append('code', _pcode);
		        	formData.append('name', file.name);
		        	formData.append('hash', itmHash);
		        	formData.append('is_main', isMain);
		        	*/

		        },
		        accept: function(file, done) { // Si la imagen es acpetable se configura la  previsualizacion y sus botones

		        	done();

		        	/*
		        	var preview = $(file.previewTemplate);

		        	var _qfiles = this.getQueuedFiles();

		        	var _this 	= this;

		        	$.each(_qfiles, function(i, item) {

		        		var itmName = CryptoJS.MD5(item.name).toString();
		        		var imgData = {  "name" : item.name , "hash" : itmName, 'isMain' : false };

		        		if($.inArray(itmName, imgToUpList)==-1) {

		        			imgToUpObjs.push(imgData);
		        			imgToUpList.push(itmName);

		        			var btn_pic 		= preview.find('.btn-pic');
		        			var btn_del 		= preview.find('.btn-del');
		        			var obj_progress	= preview.find('.progress-object');

		        			packBtnDel.push(btn_del);
		        			packBtnMain.push(btn_pic);

		        			// Boton de imagen principal
		        			btn_pic.data('cimg', itmName);
		        			btn_pic.data('img', item.name);

		        			btn_pic.on('click', function(e){

		        				mainImgName = $(this).data('cimg');

	        					$(this).removeClass('btn-success');
	        					$(this).addClass('btn-danger');

	        					if(btnImgObject==undefined) btnImgObject = btn_pic;
	        					else {

	        						btnImgObject.removeClass('btn-danger');
	        						btnImgObject.addClass('btn-success');

	        						btnImgObject = btn_pic;
	        					}

	        					$.each(imgToUpObjs, function(i, itm) {
	        						if(itm.hash == mainImgName) itm.isMain = true;
	        						else itm.isMain = false;
	        					});

	        					obj_progress.prop('id', '_p_' + itmName);

		        				e.preventDefault();
		        				e.stopPropagation();
		        			});

		        			// Boton de imagen a eliminar
		        			btn_del.data('cimg', itmName);
		        			btn_del.data('img', item.name);

		        			btn_del.on('click', function(e){

		        				var imgHash = $(this).data('cimg');

		        				if(mainImgName == imgHash) {
		        					$.bootstrapGrowl('La imagen principal no puede ser eliminada', {
				                        type: "danger",
				                        delay: 4500,
				                        allow_dismiss: true
				                    });
		        					return false;
		        				}

		        				_this.removeFile(file);

		        				imgToUpList.splice(imgToUpList.indexOf(imgHash), 1);


		        				$.each(imgToUpObjs, function(i, oitm) {
		        					if(oitm.hash == imgHash) {
		        						imgToUpObjs.splice(imgToUpObjs.indexOf(oitm), 1);
		        						return false;
		        					}
		        				});

		        				e.preventDefault();
		        				e.stopPropagation();
		        			});
		        		}

		        	});
					*/

		        },
		        complete: function(file) { // Una ves completada la carga ... [Pendinete]

		        	if(file.status=='error') return;

		        	if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

		        		// Mensaje de finalizacion de carga de producto
						$.bootstrapGrowl('Carga de producto exitosa', {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });

	                    // Ocultamos el modal
	                    $('#modal-add-product').modal('hide');
			        }

			        if(file.status=='success') {
			        	var _data           = $.parseJSON(file.xhr.response);
						//console.log(_data);
			        }

		        }
		    });

            // Fix para overmodal
	        $('#modal-link-color').on('hidden.bs.modal', function(e){
                if($('#modal-add-product').css('display')=='block') {
                   $('body').addClass('modal-open'); 
                }
                $('#form-link-color').trigger('reset');
            });

			//
            // Procesamiento de agregado de producto
            // 
			$('.btn-upload-product').click(function(e){

				// Verificamos que existan imagenes para cargar
				if(imgToUpObjs.length < 1) {
					$.bootstrapGrowl('Almenos tiene que agregar una imagen de producto', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    $('.nav-tabs a:first').tab('show');
                    return false;
				}

				// Verificamos que existe una imagen como principal
				var havingMain = false;

				$.each(imgToUpObjs, function(i, item){
					if(item.isMain==true) havingMain = true;
				});

				if(havingMain==false) {
					$.bootstrapGrowl('No a definido una imagen como principal', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    $('.nav-tabs a:first').tab('show');
                    return false;
				}

				// Establecemos el foco al tab de imagenes
				$('.nav-tabs a:first').tab('show');

				$.each(packBtnDel, function(i,item){
					item.prop('disabled', true);
				});
				$.each(packBtnMain, function(i,item){
					item.prop('disabled', true);
				});
				
				// Actualizamos la informacion de los textareas que usen CKEditor
				$.CKupdate();

				// Objeto para la informacion del formulario
				var _formData = new FormData();

				// Informacion de detalle
				var _d_form 					= $('#form-detail');
				var _d_code 					= $('#code',_d_form).val();
				var _d_stock 					= $('#stock',_d_form).val();
				var _d_title 					= $('#title',_d_form).val();
				var _d_title_eng 				= $('#title-eng',_d_form).val();
				var _d_description 				= $('#description',_d_form).val().replace(/(?:\r\n|\r|\n)/g, '');
				var _d_description_eng 			= $('#description-eng',_d_form).val().replace(/(?:\r\n|\r|\n)/g, '');
				var _d_category 				= $('#categories',_d_form).val();
				var _d_sub_category 			= $('#sub-categories',_d_form).val();
				var _d_multi_category 			= $('#multi-sub-categories',_d_form).val();
				var _d_price_public 			= $('#price_public',_d_form).val();
				var _d_price_public_usd 		= $('#price_public_usd',_d_form).val();
				var _d_price_half_wholesale 	= $('#price_half_wholesale',_d_form).val();
				var _d_price_half_wholesale_usd = $('#price_half_wholesale_usd',_d_form).val();
				var _d_price_wholesale 			= $('#price_wholesale',_d_form).val();
				var _d_price_wholesale_usd 		= $('#price_wholesale_usd',_d_form).val();
				var _d_price_dealer 			= $('#price_dealer',_d_form).val();
				var _d_price_dealer_usd 		= $('#price_dealer_usd',_d_form).val();
				var _d_gender 					= $('#gender',_d_form).val();

				// Validaciones
				// -- Detalle
				if(_d_code=='' || _d_code.length < 3) {
					$.bootstrapGrowl('Ingrese un codigo de producto valido', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_stock=='' || parseInt(_d_stock) < 0) {
					$.bootstrapGrowl('El stock no puede ser menor a 0', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_title=='' || _d_title.length < 3) {
					$.bootstrapGrowl('Ingrese un titulo valido', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_category==0) {
					$.bootstrapGrowl('Seleccione un categoria principal', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_sub_category==0) {
					$.bootstrapGrowl('Seleccione una sub-categoria', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_price_public=='' || _d_price_public_usd=='') {
					$.bootstrapGrowl('Ingrese un precio al publico valido', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_price_half_wholesale=='' || _d_price_half_wholesale_usd=='') {
					$.bootstrapGrowl('Ingrese un precio de medio mayoreo valido', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_price_wholesale=='' || _d_price_wholesale_usd=='') {
					$.bootstrapGrowl('Ingrese un precio de mayorista valido', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				if(_d_price_dealer=='' || _d_price_dealer_usd=='') {
					$.bootstrapGrowl('Ingrese un precio de distribuidor valido', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}

				// Desabilitamos todos los formularios
				$(":input", _d_form).prop("disabled", true);

				_formData.append('d_code', _d_code);
				_formData.append('d_stock', _d_stock);
				_formData.append('d_title', _d_title);
				_formData.append('d_title_eng', _d_title_eng);
				_formData.append('d_description', _d_description);
				_formData.append('d_description_eng', _d_description_eng);
				_formData.append('d_category_id', _d_category);
				_formData.append('d_sub_category_id', _d_sub_category);
				_formData.append('d_multi_category', _d_multi_category);
				_formData.append('d_price_public', _d_price_public);
				_formData.append('d_price_public_usd', _d_price_public_usd);
				_formData.append('d_price_half_wholesale', _d_price_half_wholesale);
				_formData.append('d_price_half_wholesale_usd', _d_price_half_wholesale_usd);
				_formData.append('d_price_wholesale', _d_price_wholesale);
				_formData.append('d_price_wholesale_usd', _d_price_wholesale_usd);
				_formData.append('d_price_dealer', _d_price_dealer);
				_formData.append('d_price_dealer_usd', _d_price_dealer_usd);
				_formData.append('d_gender', _d_gender);


				// Definimos la variable global del codigo de prducto y categoria
				_pcode 	= _d_code;
				_pcat 	= _d_category;

				// Informacion de relaciones de productos
				var _r_arrays 			= [];

				$.each(_relObjs, function(i, item){
					_r_arrays.push(item.id);
				});

				var _r_products 		= _r_arrays.join();

				_formData.append('r_products', _r_products);

				// Desabilitamos todos los formularios
				$(":input", "#form-relations").prop("disabled", true);

				// Formulario de extras
				var _e_form				= $("#form-extras");
				var _e_materials 		= $("#materials",_e_form).val();
				var _e_sizes			= $("#sizes",_e_form).val();
				var _e_icArray 			= [];

				// Desabilitamos todos los formularios
				$(":input", _e_form).prop("disabled", true);

				$.each(relColorCodeObjs, function(i, item){
					_e_icArray.push(item.color_id+'|'+item.item_id);
				});

				var _e_prodColorList 	= _e_icArray.join();

				_formData.append('e_materials', _e_materials);
				_formData.append('e_sizes', _e_sizes);
				_formData.append('e_item_color', _e_prodColorList);

				// Deshabilitamos los botones de cancelado y agregado de producto
				$("button.btn-upload-product").prop('disabled', true);
				$("button.btn-cancel-product").prop('disabled', true);

				// Procesamos la informacion del producto
				// 
				// Si la informacion de procesa correctamente tambien llamamos al proceso de carga de imagenes
				// En este punto el foco se mueve al tab de carga de imagenes
				// 
				$.d3pdPOST('/products/inventory/add',_formData,function(data){

					if(data.status==true) {

						// Establecemos el id del producto
						_ppid 	= data.pid;

						// Procesamos las imagenes (Paso final)
						_dz.processQueue();

					} else {

						$.bootstrapGrowl(data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });

						return false;
					}

				});

			});
 		}
 	}

 }();