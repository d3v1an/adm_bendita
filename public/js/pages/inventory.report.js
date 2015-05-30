var InventoryReportData = function() {

 	return {

 		load: function() {

 			var categories = $("#categories", "#form-detail");
 			$.loadCategories(categories, undefined, true);

 			var complex_categories = $("#multi-sub-categories", "#form-detail");
 			$.loadComplexCategories(complex_categories);

 			var materials = $("#materials", "#form-extras");
 			$.loadMaterials(materials);

 			var sizes = $("#sizes", "#form-extras");
 			$.loadSizes(sizes);

 			var colors = $("#colors", "#form-extras");
 			$.loadColors(colors);
 		},

 		init: function() {

 			var _type_change = 0;

 			$.d3POST('/products/inventory/type_change',{},function(data){
				if(data.status==true) _type_change = data.exchange;
			});

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
											                		//_buttons += '	<button class="btn btn-xs btn-danger" data-cmd="del" data-id="' + full.id + '"><i class="gi gi-bin"></i></button>';
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
											                			
											                		}
											                		else if(_cmd=='email') {
											                			// $('#order_id','#form-notify').val(_oid);
											                			// $('#order_id','#form-additional-data').val(_oid);
											                			// $('#modal-order-notify').modal('show');
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
    		var dropLimit 			= 7;

    		var previewNode 		= document.querySelector("#template");
			previewNode.id 			= "";
			var previewTemplate 	= previewNode.parentNode.innerHTML;
			previewNode.parentNode.removeChild(previewNode);

			// Listado de imagenes a cargar y su configuracion adicional
			var imgToUpList 		= [];
			var imgToUpObjs 		= [];
			var mainImgName			= null;
			var itemLinkId 			= 0;
			var btnImgObject		= undefined;

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
		        	//console.log('Completado');
		        	//console.log(this.getQueuedFiles());
		        	/*
		            if(file.status=='error') return false;

		            $('.fileprogress').slideUp('fast');
		            $('.fileprogress_proc').slideDown('slow');

		            var _data           = $.parseJSON(file.xhr.response);
		            var _status         = _data.status;
		            var _original_file  = _data.original;
		            var _original_size  = _data.original_size;
		            var _uploaded       = _data.uploaded;

		            main_width          = $('.viewrow').width();
		            img_width           = _data.width;
		            img_height          = _data.height;

		            if(img_width <= main_width) {
		                
		                $('.img-viewer').css({'width':img_width,'height':img_height});
		                $('#left-image').css({'width':img_width,'height':img_height});
		                $('#right-image').css({'width':img_width,'height':img_height});

		            } else {
		                
		                var new_size = $.resize(img_width,img_height,main_width,600);

		                $('.img-viewer').css({'width':new_size.width,'height':new_size.height});
		                $('#left-image').css({'width':new_size.width,'height':new_size.height});
		                $('#right-image').css({'width':new_size.width,'height':new_size.height});
		            }

		            if(_status==true) {
		                $.d3POST('/cjpg',{original:_original_file, original_size:_original_size, uploaded:_uploaded},function(data){

		                    $('.fileprogress_proc').slideUp('fast');
		                    $('#left-image').prop('src','/uploads/images/' + file.name);
		                    $('#right-image').prop('src','/uploads/images/' + data.image);

		                    $('.btn-fdownload').data('url',data.image);

		                    $('.data_percent').html(data.compress_percent_real);
		                    $('.data_before').html(data.original_size);
		                    $('.data_after').html(data.new_file_size);

		                    $('.img-viewer').slideDown('slow');
		                    $('.compress-info').slideDown('slow');
		                });
		            } else console.log('Mamo');
		            */
		        }
		    });

			// Detalle

			// Codigo
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
 				$.loadSubCategories(sub_categories, $(this).val());
			});

			// Autocomplete de relations
            var _form 		= $('#form-relations')
            var $input 		= $('#code', _form);
            var _table 		= $('table#relations-datatable');

            var _relList 	= [];
            var _relObjs	= []; 

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
            		$(".btn-search-code").prop('disabled', false);
            		return item.code + ' (' + item.description + ')';
            	}
            });

            $(".btn-search-code").click(function(){

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

            var relColorCodeList 	= [];
            var relColorCodeObjs	= [];

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
			    CKEDITOR.instances[instance].setData('');
			};

			// Prices
			$('#price_public, #price_half_wholesale, #price_wholesale, #price_dealer','#form-detail').on('keypress keyup',function(e){
				
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
			});

			// Fix para overmodal
	        $('#modal-add-product').on('hidden.bs.modal', function(e){
                $('#form-detail').trigger('reset');
                $("table#elations-datatable tbody").empty();
                $('#form-relations').trigger('reset');
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
				//console.log(imgToUpObjs);
				//console.log(_dz.getQueuedFiles());
				
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

				// Informacion de relaciones de productos
				var _r_arrays 			= [];

				$.each(_relObjs, function(i, item){
					_r_arrays.push(item.id);
				});

				var _r_products 		= _r_arrays.join();

				_formData.append('r_products', _r_products);

				// Formulario de extras
				var _e_form				= $("#form-extras");
				var _e_materials 		= $("#materials",_e_form).val();
				var _e_sizes			= $("#sizes",_e_form).val();
				var _e_icArray 			= [];

				$.each(relColorCodeObjs, function(i, item){
					_e_icArray.push(item.color_id+'|'+item.item_id);
				});

				var _e_prodColorList 	= _e_icArray.join();

				_formData.append('e_materials', _e_materials);
				_formData.append('e_sizes', _e_sizes);
				_formData.append('e_item_color', _e_prodColorList);

				// Procesamos la informacion del producto
				// 
				// Si la informacion de procesa correctamente tambien llamamos al proceso de carga de imagenes
				// En este punto el foco se mueve al tab de carga de imagenes
				// 
				$.d3pdPOST('/products/inventory/add',_formData,function(data){
					console.log(data);
				});

				// Procesamos las imagenes (Paso final)
				// _dz.processQueue();
			});
 		}
 	}

 }();