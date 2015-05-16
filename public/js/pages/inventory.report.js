var InventoryReportData = function() {

 	return {

 		init: function() {

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
    		Dropzone.autoDiscover = false;

    		var previewNode = document.querySelector("#template");
			previewNode.id = "";
			var previewTemplate = previewNode.parentNode.innerHTML;
			previewNode.parentNode.removeChild(previewNode);

    		var _dz = new Dropzone("div#dropzone",{
		    //var _dz = $("div#dropzone").dropzone({
		        url: "/media/image/upload",
		        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><p><span>Arrastra tu imagen ó da click.</span></p>',
		        autoProcessQueue: false,
		        uploadMultiple: false,
		        maxFiles: 7,
		        maxFilesize: 15, // 5MB
		        
		        thumbnailWidth:150,
        		thumbnailHeight:225,
        		
        		previewTemplate: previewTemplate,
		        previewsContainer: "#previews",

		        dictFileTooBig: 'tb:La imagen es demasiado grande',
		        acceptedFiles: 'image/jpeg,image/jpg',
		        dictInvalidFileType: 'uf:Archivo no soportado',

		        maxfilesexceeded: function(file) {
		            // displayNotification('error', 'Ha superado el número máximo de imágenes a cargar.', 4000);
		            $.bootstrapGrowl('Ha superado el número máximo de imágenes a cargar.', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
		            this.removeFile(file);
		        },
		        error: function(file, response) {
		            if($.type(response) === "string") {
		                var err = response.split(':');
		                if(err[0]=='tb') {
		                    // displayNotification('error', file.name + ' ' + err[1], 4000);
		                    $.bootstrapGrowl(file.name + ' ' + err[1], {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
		                    this.removeFile(file);
		                } else if(err[0]=='uf') {
		                    // displayNotification('error', file.name + ' ' + err[1], 4000);
		                    $.bootstrapGrowl(file.name + ' ' + err[1], {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
		                    this.removeFile(file);
		                }// else console.log(response);
		            }
		        },
		        sending: function(file) {
		            console.log('Cargando archivo al servidor');
		            //$('#dropzone').fadeOut('fast').slideUp('fast');
		            //$('.fileprogress').fadeIn('fast').slideDown('slow');
		        },
		        uploadprogress: function(file, progress, bytesSent) {
		            //$('.upprogress').css('width', progress+'%').html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + Math.round(progress) + '% Cargado..');
		            console.log(progress);
		            console.log(bytesSent);
		        },
		        complete: function(file) {
		        	console.log(file);
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

			// _dz.on("addedfile", function(file) {
			//   // Hookup the start button
			//   file.previewElement.querySelector(".start").onclick = function() { _dz.enqueueFile(file); };
			// });

			$('.btn-upload-product').click(function(e){
				_dz.processQueue();
			});
 		}
 	}

 }();