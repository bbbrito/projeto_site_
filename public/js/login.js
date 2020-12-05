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
				if (json["status"] == 1) {
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
					$("#modal_user").modal("hide");
					swal("Sucesso!","Usuário salvo com sucesso!", "success");
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
	});

})