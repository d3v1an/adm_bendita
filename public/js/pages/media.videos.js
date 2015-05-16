var MediaData = function() {

 	return {

 		init: function() {

 			// Tabla Handler select de videos
 			$("table.table-video-report tbody tr td").on('change','select',function(){
 				
 				var _val 	= $(this).val();
 				var _id 	= $(this).data('id');

				$.d3POST('/media/video',{id:_id,status:_val},function(data){
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

 			// Tabla Handler click de videos
 			$("table.table-video-report tbody tr td").on('click','button',function(){
 				
 				console.log($(this).data('cmd'));

 				var _cmd 	= $(this).data('cmd')
 				var _id 	= $(this).data('id');

 				if(_cmd=='del') {

 					var _confirm = confirm('Realmente desea eliminar el video seleccionado?');

 					if(_confirm==true) {
 						$.d3POST('/media/video/delete',{id:_id},function(data){
	 						if(data.status==true) {
		                        $.bootstrapGrowl(data.message, {
		                            type: "success",
		                            delay: 4500,
		                            allow_dismiss: true
		                        });
		                        $("table.table-video-report tbody tr[id='_v_" + _id + "']").remove();
		                    } else {
		                        $.bootstrapGrowl(data.message, {
		                            type: "danger",
		                            delay: 4500,
		                            allow_dismiss: true
		                        });
		                    }
	 					});
 					}

 				} else if(_cmd=='edit') {

 					$.d3POST('/media/video/info',{id:_id},function(data){

 						if(data.status==true) {

 							var _form = $('#form-video-edit');

 							$('#id', _form).val(_id);
 							$('#name', _form).val(data.info.name);
 							$('#label', _form).val(data.info.label);
 							$('#link', _form).val(data.info.link);

 							$('#modal-video-edit').modal('show');
 						} else {
 							$.bootstrapGrowl('No pudo obtenerse la informacion del video', {
	                            type: "danger",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
 						}

 					});
	
 				}

 			});

 			// Validacion de edicion de video
	        var _formVideoEditData   = $('#form-video-edit');

	        _formVideoEditData.validate({
				errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
				errorElement: 'div',
				errorPlacement: function(error, e) {
					e.parents('.form-group > div').append(error);
				},
				highlight: function(e) {
					$(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
					$(e).closest('.help-block').remove();
				},
				success: function(e) {
					e.closest('.form-group').removeClass('has-success has-error');
					e.closest('.help-block').remove();
				},
				rules: {
					'name': {
				    	required: true,
				    	minlength: 3
					},
					'label': {
				    	required: true,
				    	minlength: 3
					},
					'link': {
				    	required: true
					}
				},
				messages: {
					'name': {
						required: 'Por favor ingrese un nombre video',
						minlength: 'Debe contener almenos 3 caracteres'
					},
					'label': {
						required: 'Ingrese una etiqueta',
						minlength: 'Debe contener almenos 3 caracteres'
					},
					'link': {
						required: 'Por favor ingrese un link'
					}
				},
				submitHandler: function(form) {

					$("#form-video-edit :input").prop("disabled", true);

					var _id 		= $('#id',_formVideoEditData).val();
					var _name 		= $('#name',_formVideoEditData).val();
					var _label 		= $('#label',_formVideoEditData).val();
					var _link 		= $('#link',_formVideoEditData).val();

					var _g 			= $.bootstrapGrowl;

					$.d3POST('/media/video/edit',{id:_id,name:_name,label:_label,link:_link},function(data){

					    if(data.status==true) {
					        
					        _g(data.message, {
					            type: "success",
					            delay: 4500,
					            allow_dismiss: true
					        });

					        var _table = $("table.table-video-report tbody tr[id='_v_" + _id + "']");

					        $('td.vname', _table).html(_name);
					        $('td.vlabel', _table).html(_label);
					        $('td.vlink', _table).html(_link);

					    	$('#modal-video-edit').modal('hide');
					    	$("#form-video-edit :input").prop("disabled", false);

					    } else {
					        
					        _g(data.message, {
					            type: "danger",
					            delay: 4500,
					            allow_dismiss: true
					        });

					    }

					});

				}
			});

			// Validacion de agregado de video
	        var _formVideoAddData   = $('#form-video-add');

	        _formVideoAddData.validate({
				errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
				errorElement: 'div',
				errorPlacement: function(error, e) {
					e.parents('.form-group > div').append(error);
				},
				highlight: function(e) {
					$(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
					$(e).closest('.help-block').remove();
				},
				success: function(e) {
					e.closest('.form-group').removeClass('has-success has-error');
					e.closest('.help-block').remove();
				},
				rules: {
					'name': {
				    	required: true,
				    	minlength: 3
					},
					'label': {
				    	required: true,
				    	minlength: 3
					},
					'link': {
				    	required: true
					}
				},
				messages: {
					'name': {
						required: 'Por favor ingrese un nombre video',
						minlength: 'Debe contener almenos 3 caracteres'
					},
					'label': {
						required: 'Ingrese una etiqueta',
						minlength: 'Debe contener almenos 3 caracteres'
					},
					'link': {
						required: 'Por favor ingrese un link'
					}
				},
				submitHandler: function(form) {

					$("#form-video-add :input").prop("disabled", true);

					var _name 		= $('#name',_formVideoAddData).val();
					var _label 		= $('#label',_formVideoAddData).val();
					var _link 		= $('#link',_formVideoAddData).val();
					var _status		= $('#status',_formVideoAddData).val();

					var _g 			= $.bootstrapGrowl;

					$.d3POST('/media/video/add',{name:_name,label:_label,link:_link,status:_status},function(data){

					    if(data.status==true) {
					        
					        _g(data.message, {
					            type: "success",
					            delay: 4500,
					            allow_dismiss: true
					        });

					    	$('#modal-video-add').modal('hide');
					    	$("#form-video-edit :input").prop("disabled", false);

					    	window.location.reload();

					    } else {
					        
					        _g(data.message, {
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