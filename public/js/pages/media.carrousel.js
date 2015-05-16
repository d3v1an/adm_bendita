var MediaData = function() {

 	return {

 		init: function() {

    		// Boton para ver las imagenes cargadas
			$('.g-link').magnificPopup({
				type: 'image'
			});

			// Actualizacion de si es o no linkeable
			$("table.table-carrousel-report tbody tr td").on('change',':checkbox',function(){
				$.tableCheckHandler(this);
			});

			// Actualizacion de categoria y estatus
			$("table.table-carrousel-report tbody tr td").on('change','select',function(){
				$.tableSelectHandler(this);
			});

			// Opciones para ediciony elimnado de items
			$("table.table-carrousel-report tbody tr td").on('click','button',function(){
				$.tableClickHandler(this);
			});

			// Zona de dropzone para actualizar la imagen
			// Disable auto discover for all elements:
    		Dropzone.autoDiscover = false;

    		// Dropzone class:
		    var _dz = new Dropzone("div#dropzone",{
		        url: "/media/carrousel/edit",
		        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><p><span>Arrastra tu imagen ó da click.</span></p>',
		        autoProcessQueue: false,
		        uploadMultiple: false,
		        previewsContainer: false,
		        maxFiles: 1,
		        maxFilesize: 100, // 100MB
		        dictFileTooBig: 'tb:La imagen es demasiado grande',
		        acceptedFiles: 'image/jpeg,image/jpg',
		        dictInvalidFileType: 'uf:Archivo no soportado',
		        maxfilesexceeded: function(file) {
		            $.bootstrapGrowl('Ha superado el número máximo de imágenes a cargar.', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
		            this.removeFile(file);
		        },
		        error: function(file, response) {

		            if($.type(response) === "string") {
		                
		                var err 	= response.split(':');
		                var serr 	= '';

		                if(err[0]=='tb') {
		                    serr = file.name + ' ' + err[1];
		                    this.removeFile(file);
		                } else if(err[0]=='uf') {
		                    serr = file.name + ' ' + err[1];
		                    this.removeFile(file);
		                }

		                $.bootstrapGrowl(serr, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
		            }
		        },
		        sending: function(file, xhr, formData) {

		        	var _form 	= $('#form-carrousel-edit');
					var _id 	= $('#id', _form).val();
					var _link 	= $('#link', _form).val();

		        	formData.append('id', _id);
		        	formData.append('link', _link);
		        	formData.append('image', true);
		            
		            $('#dropzone').fadeOut('fast').slideUp('fast');
		            $('.fileprogress').fadeIn('fast').slideDown('slow');
		        },
		        uploadprogress: function(file, progress, bytesSent) {
		            if(Math.round(progress) < 100) $('.upprogress').css('width', progress+'%').html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + Math.round(progress) + '% Cargado..');
		            else $('.upprogress').css('width', progress+'%').html(Math.round(progress) + '% completado..');
		        },
		        complete: function(file) {

		            if(file.status=='error') {
		            	$.bootstrapGrowl(_data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
	                    $('#modal-carrousel-edit').modal('hide');
		            	return false;
		            }

		            var _data           = $.parseJSON(file.xhr.response);
		            var _status         = _data.status;

		            if(_status==true) {
		            	
		            	$.bootstrapGrowl(_data.message, {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });

	                    var _tr = $("table.table-carrousel-report tbody tr[id='_c_" + _data.id + "']");
	                    $('td.vlink', _tr).html('<a href="' + _data.link + '" target="_blank">' + _data.link + '</a>');
	                    $('td.vimage', _tr).html('<a href="' + _data.url + '" class="g-link"><i class="gi gi-camera"></i></a>');
	                    $('.g-link').magnificPopup({type: 'image'});

		            } else {
		            	$.bootstrapGrowl(_data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
		            }

		            $('#modal-carrousel-edit').modal('hide');
		        }
		    });

			// Prevenimos que el formulario de actualizacion de item se auto-envie
			$('#form-carrousel-edit').submit(function(e){
				e.preventDefault();
			});

			// Boton para actualizacion de informacion del item seleccionado
			$('.btn-carrousel-update').click(function(e){

				// Contamos si hay imagen para actualizar
				var _fileToUpload = (_dz.getQueuedFiles().length>0);

				var _form 	= $('#form-carrousel-edit');

				var _id 	= $('#id', _form).val();
				var _link 	= $('#link', _form).val(); 

				if(_link=='') {
					$.bootstrapGrowl('El campo link no puede estar vacio', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
                    return false;
				}
				
				// Si existe la imagen esta es actualizada junto con la informacion del formulario
				// de lo contrario solo se actualiza la informacion del formulario
				if(_fileToUpload) {
					_dz.processQueue();
				} else {

					$.d3POST('/media/carrousel/edit',{id:_id,link:_link,image:false},function(data){
			            if(data.status==true) {
			                
			                $.bootstrapGrowl(data.message, {
		                        type: "success",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });

		                    var _tr 	= $("table.table-carrousel-report tbody tr[id='_c_" + _id + "']");
		                    var _dlink 	= '<a href="' + _link + '" target="_blank">' + _link + '</a>';

		                    $('td.vlink', _tr).html(_dlink);
		                    $('#modal-carrousel-edit').modal('hide');

			            } else {
			            	$.bootstrapGrowl(data.message, {
		                        type: "danger",
		                        delay: 4500,
		                        allow_dismiss: true
		                    });
			            }
			        });
				}

			    e.preventDefault();
			});

			// Cuando se cierra el modal de actualizacion de datos del link se eliminan las imagenes en cola si existen
			$('#modal-carrousel-edit').on('hidden.bs.modal', function (e) {
				$('.upprogress').css('width','0%');
				$('.fileprogress').fadeOut('fast').slideUp('slow');
		       	$('#dropzone').fadeIn('fast').slideDown('fast');
				_dz.removeAllFiles();
			});

			// Dropzone de carga de nuevo item
			// Dropzone class:
		    var _dzb = new Dropzone("div#dropzone-add",{
		        url: "/media/carrousel/add",
		        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><p><span>Arrastra tu imagen ó da click.</span></p>',
		        autoProcessQueue: false,
		        uploadMultiple: false,
		        previewsContainer: false,
		        maxFiles: 1,
		        maxFilesize: 100, // 100MB
		        dictFileTooBig: 'tb:La imagen es demasiado grande',
		        acceptedFiles: 'image/jpeg,image/jpg',
		        dictInvalidFileType: 'uf:Archivo no soportado',
		        maxfilesexceeded: function(file) {
		            $.bootstrapGrowl('Ha superado el número máximo de imágenes a cargar.', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
		            this.removeFile(file);
		        },
		        error: function(file, response) {

		            if($.type(response) === "string") {
		                
		                var err 	= response.split(':');
		                var serr 	= '';

		                if(err[0]=='tb') {
		                    serr = file.name + ' ' + err[1];
		                    this.removeFile(file);
		                } else if(err[0]=='uf') {
		                    serr = file.name + ' ' + err[1];
		                    this.removeFile(file);
		                }

		                $.bootstrapGrowl(serr, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
		            }
		        },
		        sending: function(file, xhr, formData) {

		        	var _form 		= $('#form-carrousel-add');
					
					var _title 		= $('#title', _form).val();
					var _linkable 	= $('#linkable', _form).is(':checked');
					var _link 		= $('#link', _form).val();
					var _category	= $('#category', _form).val();
					var _status		= $('#status', _form).val();

		        	formData.append('title', _title);
		        	formData.append('linkable', _linkable);
		        	formData.append('link', _link);
		        	formData.append('category', _category);
		        	formData.append('status', _status);
		            
		            $('#dropzone-add').fadeOut('fast').slideUp('fast');
		            $('.fileprogress-add').fadeIn('fast').slideDown('slow');
		        },
		        uploadprogress: function(file, progress, bytesSent) {
		            if(Math.round(progress) < 100) $('.upprogress-add').css('width', progress+'%').html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + Math.round(progress) + '% Cargado..');
		            else $('.upprogress-add').css('width', progress+'%').html(Math.round(progress) + '% completado..');
		        },
		        complete: function(file) {

		        	if(file.status=='error') {
		            	console.log(file);
		            	$.bootstrapGrowl('Ocurrio un problema en la carga del item', {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
	                    $('#modal-carrousel-add').modal('hide');
		            	return false;
		            }

		            var _data           = $.parseJSON(file.xhr.response);
		            var _status         = _data.status;

		            if(_data.status==false) {
		            	$.bootstrapGrowl(_data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
	                    $('#modal-carrousel-add').modal('hide');
		            	return false;
		            }

		            if(_status==true) {
		            	
		            	$.bootstrapGrowl(_data.message, {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });

		            	var _table 	= $("table.table-carrousel-report tbody");

		            	var _tr 	 = '<tr id="_c_' + _data.id + '">';
		            		_tr 	+= '	<td class="vimage"><a href="' + _data.image + '" class="g-link"><i class="gi gi-camera"></i></a></td>';
		            		_tr 	+= '	<td class="vtitle">' + _data.title + '</td>';
		            		_tr 	+= '	<td class="vlinkable"><input type="checkbox" data-id="' + _data.id + '" value="linkable" name="cb_' + _data.id + '" id="cb_' + _data.id + '" ' + (_data.linkable==1?'checked':'') + '></td>';
		            		_tr 	+= '	<td class="vlink"><a href="' + _data.link + '" target="_blank">' + _data.link + '</a></td>';
		            		_tr 	+= '	<td>';
		            		_tr 	+= '		<select data-id="' + _data.id + '" name="category" id="category">';
		            		_tr 	+= '			<option value="0" ' + (_data.category==0?'selected':'') + '>Todas</option>';
		            		_tr 	+= '			<option value="1" ' + (_data.category==1?'selected':'') + '>Lenceria</option>';
		            		_tr 	+= '			<option value="2" ' + (_data.category==2?'selected':'') + '>Zapatos</option>';
		            		_tr 	+= '			<option value="3" ' + (_data.category==3?'selected':'') + '>Jueguetes</option>';
		            		_tr 	+= '			<option value="4" ' + (_data.category==4?'selected':'') + '>Accesorios</option>';
		            		_tr 	+= '		</select>';
		            		_tr 	+= '	</td>';
		            		_tr 	+= '	<td>';
		            		_tr 	+= '		<select data-id="' + _data.id + '" name="status" id="status">';
		            		_tr 	+= '			<option value="1" ' + (_data.status==1?'selected':'') + '>Activo</option>';
		            		_tr 	+= '			<option value="0" ' + (_data.status==0?'selected':'') + '>Inactivo</option>';
		            		_tr 	+= '		</select>';
		            		_tr 	+= '	</td>';
		            		_tr 	+= '	<td class="vorder">';
		            		_tr 	+= '		(<span>' + _data.order + '</span>)';
		            		_tr 	+= '		<div class="btn-group btn-group-xs">';
		            		_tr 	+= '			<button class="btn btn-default" data-cmd="up" data-id="' + _data.id + '" data-order="' + _data.order + '"><i class="gi gi-up_arrow"></i></button>';
		            		_tr 	+= '			<button class="btn btn-default" data-cmd="down" data-id="' + _data.id + '" data-order="' + _data.order + '"><i class="gi gi-down_arrow"></i></button>';
		            		_tr 	+= '		</div>';
		            		_tr 	+= '	</td>';
		            		_tr 	+= '	<td>';
		            		_tr 	+= '		<div class="btn-group btn-group-xs">';
		            		_tr 	+= '			<button class="btn btn-default" data-cmd="edit" data-id="' + _data.id + '"><i class="gi gi-pencil"></i></button>';
		            		_tr 	+= '			<button class="btn btn-danger" data-cmd="del" data-id="' + _data.id + '"><i class="fa fa-times"></i></button>';
		            		_tr 	+= '		</div>';
		            		_tr 	+= '	</td>';
		            		_tr 	+= '</tr>';

		            		_table.append(_tr);
		            		
		            		$('tr[id="_c_' + _data.id + '"] td', _table).on('change','select',function(){
		            			$.tableSelectHandler(this);
		            		});

		            		$('tr[id="_c_' + _data.id + '"] td', _table).on('change',':checkbox',function(){
								$.tableCheckHandler(this);
							});

							// Opciones para ediciony elimnado de items
							$('tr[id="_c_' + _data.id + '"] td', _table).on('click','button',function(){
								$.tableClickHandler(this);
							});

							// Boton de imagen
		            		$('.g-link').magnificPopup({type: 'image'});

		            } else {
		            	$.bootstrapGrowl(_data.message, {
	                        type: "danger",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
		            }

		            $('#modal-carrousel-add').modal('hide');
		        }
		    });

			// Boton para agregar un nuevo item
			$('.btn-carrousel-add').click(function(e){

				var _fileToUpload = (_dzb.getQueuedFiles().length>0);

				if(!_fileToUpload) {
					$.bootstrapGrowl('Seleccione una imagen para cargar el nuevo item', {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
					return false;
				}

				_dzb.processQueue();

				e.preventDefault();
			});

			// Cuando se cierra el modal de actualizacion de datos del link se eliminan las imagenes en cola si existen
			$('#modal-carrousel-add').on('hidden.bs.modal', function (e) {
				$("#form-carrousel-add").trigger('reset');
				$('.upprogress-add').css('width','0%');
				$('.fileprogress-add').fadeOut('fast').slideUp('slow');
		       	$('#dropzone-add').fadeIn('fast').slideDown('fast');
				_dzb.removeAllFiles();
			});

			// Handler para seleccts de una tabla
			$.tableSelectHandler = function(_this) {
				
				var _type 	= $(_this).prop('id');
				var _id 	= $(_this).data('id');
				var _val 	= $(_this).val();

				if(_type=='category') {

					$.d3POST('/media/carrousel/category',{id:_id,category:_val},function(data){
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

				} else if(_type=='status') {

					$.d3POST('/media/carrousel/status',{id:_id,status:_val},function(data){
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
			}

			// Handler para checkboxes
			$.tableCheckHandler = function(_this) {

				var _state 	= ($(_this).is(':checked')?1:0);
				var _id 	= $(_this).data('id');

				$.d3POST('/media/carrousel/linkable',{id:_id,state:_state},function(data){
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

			// Handler para botones
			$.tableClickHandler = function(_this) {

				var _type 	= $(_this).data('cmd');
				var _id 	= $(_this).data('id');
				var _val 	= $(_this).val();

				var _row	= $(_this).parents("tr");
				var _order	= $(_this).data('order');

				if(_type=='edit') {

					var _form = $('#form-carrousel-edit');

					$.d3POST('/media/carrousel/info',{id:_id},function(data){
						if(data.status==true) {
							$('#id', _form).val(_id);
							$('#link', _form).val(data.info.link);
							$('#modal-carrousel-edit').modal('show');
						} else {
							$.bootstrapGrowl(data.message, {
	                            type: "danger",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
						}
					});

				} else if(_type=='del') {

					var _confirm = confirm('Realmente deseas elimnar el item seleccionado?');

					if(_confirm==false) return false;

					$.d3POST('/media/carrousel/delete',{id:_id},function(data){
						if(data.status==true) {
	                        $.bootstrapGrowl(data.message, {
	                            type: "success",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
	                        $("table.table-carrousel-report tbody tr[id='_c_" + _id + "']").remove();
	                    } else {
	                        $.bootstrapGrowl(data.message, {
	                            type: "danger",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
	                    }
					});

				} else if(_type=='up') {

					var is_first    = $(_this).parents("tr").is(':first-child');

					if(is_first) {
						$.bootstrapGrowl('No se puede subir mas ya que es el item inicial', {
                            type: "danger",
                            delay: 4500,
                            allow_dismiss: true
                        });
                        return false;
					}

					var objReOrder 	= MediaData.itemPrincipalUpHandler(_id,_order);

					if(objReOrder==false) {
						$.bootstrapGrowl('Ocurrio un problema al actualizar la condicion del item', {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
						return false;
					}

					var tr2Ed 		= $('table.table-carrousel-report tbody tr[id="_c_'+objReOrder.current.id+'"]').find("td").eq(6);
					
					$('span',tr2Ed).html('').html(objReOrder.current.new_order);
					$('div button[data-cmd="up"]',tr2Ed).data('order',objReOrder.current.new_order);
					$('div button[data-cmd="down"]',tr2Ed).data('order',objReOrder.current.new_order);

					var tr2EdB       = $('table.table-carrousel-report tbody tr[id="_c_'+objReOrder.target.id+'"]').find("td").eq(6);

					$('span',tr2EdB).html('').html(objReOrder.target.new_order);
					$('div button[data-cmd="up"]',tr2EdB).data('order',objReOrder.target.new_order);
					$('div button[data-cmd="down"]',tr2EdB).data('order',objReOrder.target.new_order);

					_row.insertBefore(_row.prev());


				} else if(_type=='down') {

					var is_last    = $(_this).parents("tr").is(':last-child');

					if(is_last) {
						$.bootstrapGrowl('No se puede bajar mas ya que es el item final', {
                            type: "danger",
                            delay: 4500,
                            allow_dismiss: true
                        });
                        return false;
					}

					var objReOrder 	= MediaData.itemPrincipalDownHandler(_id,_order);

					if(objReOrder==false) {
						$.bootstrapGrowl('Ocurrio un problema al actualizar la condicion del item', {
	                        type: "success",
	                        delay: 4500,
	                        allow_dismiss: true
	                    });
						return false;
					}

					var tr2Ed 		= $('table.table-carrousel-report tbody tr[id="_c_'+objReOrder.current.id+'"]').find("td").eq(6);
					
					$('span',tr2Ed).html('').html(objReOrder.current.new_order);
					$('div button[data-cmd="up"]',tr2Ed).data('order',objReOrder.current.new_order);
					$('div button[data-cmd="down"]',tr2Ed).data('order',objReOrder.current.new_order);

					var tr2EdB       = $('table.table-carrousel-report tbody tr[id="_c_'+objReOrder.target.id+'"]').find("td").eq(6);

					$('span',tr2EdB).html('').html(objReOrder.target.new_order);
					$('div button[data-cmd="up"]',tr2EdB).data('order',objReOrder.target.new_order);
					$('div button[data-cmd="down"]',tr2EdB).data('order',objReOrder.target.new_order);

					_row.insertAfter(_row.next());
				}
			}
 		},

 		// Funcion para subir un nivel el item seleccionado
 		itemPrincipalUpHandler: function(id,order) {

	        var output = false;

	        $.d3POST('/media/carrousel/principal/up',{id:id,order:order},function(data){
	            if(data.status==true) {
	                $.bootstrapGrowl(data.message, {
                        type: "success",
                        delay: 4500,
                        allow_dismiss: true
                    });
	                output = data.re_order;
	            } else {
	            	$.bootstrapGrowl(data.message, {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
	            }
	         },false);

        	return output;
    	},

    	// Funcion para bajar un nivel el item seleccionado
    	itemPrincipalDownHandler: function(id,order) {

	        var output = false;

	        $.d3POST('/media/carrousel/principal/down',{id:id,order:order},function(data){
	            if(data.status==true) {
	                $.bootstrapGrowl(data.message, {
                        type: "success",
                        delay: 4500,
                        allow_dismiss: true
                    });
	                output = data.re_order;
	            } else {
	            	$.bootstrapGrowl(data.message, {
                        type: "danger",
                        delay: 4500,
                        allow_dismiss: true
                    });
	            }
	         },false);

        	return output;
    	}
 	}

 }();