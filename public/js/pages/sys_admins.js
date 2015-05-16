var SysAdmins   = function() {

 	return {

 		init: function() {

 			$("table.table-admin-report tbody tr td").on('change','select',function(){
 				
 				var _type 	= $(this).prop('id');
 				var _val 	= $(this).val();
 				var _uid 	= $(this).data('uid');

 				if(_type=='level') {

 					$.d3POST('/system/admins/update/level',{id:_uid,level:_val},function(data){
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

 					$.d3POST('/system/admins/update/status',{id:_uid,status:_val},function(data){
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

 			$("table.table-admin-report tbody tr td").on('click','button',function(){
 				
 				var _uid = $(this).data('uid');
 				
 				var _confirm = confirm('Realmente desea eliminar al usuario seleccionado?');

 				if(_confirm==true) {
 					
 					$.d3POST('/system/admins/delete',{id:_uid},function(data){
 						if(data.status==true) {
	                        $.bootstrapGrowl(data.message, {
	                            type: "success",
	                            delay: 4500,
	                            allow_dismiss: true
	                        });
	                        $("table.table-admin-report tbody tr[id='_uid_" + _uid + "']").remove();
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

 			// Edit own settings
	        var _formAddAdminData   = $('#form-user-add');

	        _formAddAdminData.validate({
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
					'username': {
				    	required: true,
				    	minlength: 3,
				    	lettersonly: true
					},
					'first-name': {
				    	required: true,
				    	minlength: 3
					},
					'password': {
				    	required: true,
				    	minlength: 5
					},
					repassword: {
				    	equalTo: "#password"
				    }
				},
				messages: {
					'username': {
						required: 'Por favor ingrese un nombre usuario',
						minlength: 'Debe contener almenos 3 caracteres',
						lettersonly: 'Solo de admiten letras'
					},
					'first-name': {
						required: 'Por favor ingrese un nombre',
						minlength: 'Debe contener almenos 3 caracteres'
					},
					'password': {
						required: 'Por favor ingrese una contraseña',
						minlength: 'Debe contener almenos 5 caracteres'
					},
					repassword: {
				    	equalTo: 'La contraseña y la confirmacion no coinciden'
				    }
				},
				submitHandler: function(form) {

					$("#form-user-add :input").prop("disabled", true);

					var _role 		= $('#level',_formAddAdminData).val();
					var _username 	= $('#username',_formAddAdminData).val();
					var _fname 		= $('#first-name',_formAddAdminData).val();
					var _password 	= $('#password',_formAddAdminData).val();

					var _g 			= $.bootstrapGrowl;

					$.d3POST('/system/admins/add',{username:_username,name:_fname,level:_role,password:_password},function(data){

					    if(data.status==true) {
					        
					        _g(data.message, {
					            type: "success",
					            delay: 4500,
					            allow_dismiss: true
					        });

					        $('#modal-user-add').modal('hide');
					        $("#form-user-add :input").prop("disabled", false);

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