$(function() {

	$("#login_form").submit(function() {

		$.ajax({
			type: "post",
			url: BASE_URL + "restrict/ajax_login",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_login").parent().siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(json) {
				if (json["status"]) {
					clearErrors();
					$("#btn_login").parent().siblings(".help-block").html(loadingImg("Logando..."));
					window.location = BASE_URL + "restrict";
				} else {
					showErrors(json["error_list"]);
				}
			},
			error: function(response) {
				console.log(response);
			}
		})

		return false;
	})

	$("#btn_register").click(function(){
		clearErrors();
		$("#form_new_user")[0].reset();
		$("#modal_user").modal();
	});

	$("#forgot_password").click(function(){
		clearErrors();
		$("#form_forgot_password")[0].reset();
		$("#modal_forgot_password").modal();
	});

	$("#form_new_user").submit(function() {
		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_user",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_user").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"]) {
				swal("Sucesso!","Usuário salvo com sucesso! Você receberá um e-mail com um link para confirmação de cadastro.", "success");
					$("#modal_user").modal("hide");
							$.ajax({
								type: "POST",
								data: "email="+response["confirmation"]["email_user"]+"&token="+response["confirmation"]["token"],
								url: BASE_URL + "restrict/send_new_user_email",
								success: function(response) {
									clearErrors();
								}
							})
				} else {
					showErrorsModal(response["error_list"]);
				}
			}
		})

		return false;
	});

	$("#form_forgot_password").submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_forgot_password",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_forgot_password").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"]) {
				swal("Verifique seu e-mail!","Siga as instruções no e-mail que enviamos a "+response["confirmation"]["email_user"]+" para cadastrar nova senha. Faça isso imediatamente, porque o link no e-mail expirará em breve.", "success");				
					$("#modal_forgot_password").modal("hide");
							$.ajax({
								type: "POST",
								data: "email="+response["confirmation"]["email_user"]+"&token="+response["confirmation"]["token"],
								url: BASE_URL + "restrict/send_new_password_email",
								success: function(response) {
									clearErrors();
								}
							})
				} else {
					showErrorsModal(response["error_list"]);
				}
			}
		})

		return false;
	});

	$("#form_password").submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "password/ajax_save_new_password",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_new_password").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"] == 1) {
					swal({
						title: "Sucesso!",
						text: "Nova senha cadastrada com sucesso",
						type: "success",
						confirmButtonText: "Ok",
						closeOnConfirm: true,
					}).then((result) => {
						if (result.value) {
							window.location = BASE_URL + "restrict";
						}
					})
				} 
				else if (response["status"] == 2) {
					swal({
						title: "Atenção!",
						text: "Este link já expirou!",
						type: "warning",
						confirmButtonColor: "#d9534f",
						confirmButtonText: "Ok",
						closeOnConfirm: true,
					}).then((result) => {
						if (result.value) {
							window.location = BASE_URL + "restrict";
						}
					})
				}
				else {
					showErrors(response["error_list"]);
				}
			}
		})

		return false;
	});


})