$(function(){

	// Exibir Modais
	$("#btn_add_advert").click(function(){
		clearErrors();
		$("#form_advert")[0].reset();
		$("#advert_img_path").attr("src", "");
		$("#modal_advert").modal();
	});

	$("#btn_new_advert").click(function(){
		clearErrors();
		$("#form_advert")[0].reset();
		$("#advert_img_path").attr("src", "");
		$("#modal_advert").modal();
	});

	$("#btn_new_advert_on_deleteds").click(function(){
		clearErrors();
		$("#form_advert")[0].reset();
		$("#advert_img_path").attr("src", "");
		$("#modal_advert").modal();
	});

	$("#btn_add_user").click(function(){
		clearErrors();
		$("#form_user")[0].reset();
		$("#modal_user").modal();
	});


	$("#btn_upload_advert_img").change(function(){
		uploadImg($(this), $("#advert_img_path"), $("#advert_img"));
	});

	$("#form_advert").submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_advert",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_advert").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"]) {
					$("#modal_advert").modal("hide");
					swal("Sucesso!","Anúncio salvo com sucesso!", "success");
					dt_advert.ajax.reload();
					dt_new_advert.ajax.reload();
					dt_deleted_advert.ajax.reload();
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
	});

	$("#form_user").submit(function() {

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
					dt_user.ajax.reload();
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
	});

	$("#btn_your_user").click(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_get_user_data",
			dataType: "json",
			data: {"id_user": $(this).attr("id_user")},
			success: function(response) {
				clearErrors();
				$("#form_user")[0].reset();
				$.each(response["input"], function(id, value){
					$("#"+id).val(value);
				});
				$("#modal_user").modal();
			}
		})

		return false;
	});

	//Ativa edição de anúncios (ativada após carregar o datatable)

	function active_btn_advert() {
		
		$(".btn-edit-advert").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_advert_data",
				dataType: "json",
				data: {"id_advert": $(this).attr("id_advert")},
				success: function(response) {
					clearErrors();
					$("#form_advert")[0].reset();
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					$("#advert_img_path").attr("src", response["img"]["advert_img_path"]);
					$("#modal_advert").modal();
				}
			})
		});

		//Ativa o botão para deletar anúncios e retirar visualização dos ativos

		$(".btn-del-advert").click(function(){
			
			id_advert = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja deletar esse anúncio?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_delete_advert_data",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_advert.ajax.reload();
						}
					})
				}
			})

		});
	}

	//Ativa listagem de anúncios (carregar o datatable)

	var dt_advert = $("#dt_adverts").DataTable({
		"oLanguage": DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": BASE_URL + "restrict/ajax_list_advert",
			"type": "POST",
		},
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		"drawCallback": function() {
			active_btn_advert();
		}
	});

	//Ativa edição de anúncios em aprovação

	function active_btn_new_advert() {
		
		$(".btn-edit-new-advert").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_advert_data",
				dataType: "json",
				data: {"id_advert": $(this).attr("id_advert")},
				success: function(response) {
					clearErrors();
					$("#form_advert")[0].reset();
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					$("#advert_img_path").attr("src", response["img"]["advert_img_path"]);
					$("#modal_advert").modal();
				}
			})
		});

		//Ativa o botão para excluir definitivamente anúncios em aprovação

		$(".btn-exclude-new-advert").click(function(){
			
			id_advert = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja deletar definitivamente esse anúncio?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_exclude_advert_data",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_new_advert.ajax.reload();
						}
					})
				}
			})

		});

		//Ativa o botão para aprovar anúncios

		$(".btn-approve-new-advert").click(function(){
			
			id_advert = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja aprovar esse anúncio?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_approve_advert_data",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_new_advert.ajax.reload();
						}
					})
				}
			})

		});

		//Ativa o botão para aprovar todos os anúncios

		$("#btn_approve_all").click(function(){
			
			swal({
				title: "Atenção!",
				text: "Deseja aprovar todos os anúncios?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_approve_all_advert_data",
						dataType: "json",
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_new_advert.ajax.reload();
						}
					})
				}
			})

		});
	}

	//Ativa listagem de novos anúncios

	var dt_new_advert = $("#dt_new_adverts").DataTable({
		"oLanguage": DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": BASE_URL + "restrict/ajax_list_new_advert",
			"type": "POST",
		},
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		"drawCallback": function() {
			active_btn_new_advert();
		}
	});

	//Ativa a aprovação de um conjunto de anúncios

	$("#dt_new_adverts").submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_approve_all_advert_data",
			dataType: "json",
			data: $(this).serialize(),
			success: function(response) {
				clearErrors();
				if (response["status"]) {
					swal("Sucesso!","Anúncio salvo com sucesso!", "success");
					dt_new_advert.reload();
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
	});



	//Ativa edição de anúncios deletados pelo usuário, mas não excluídos definitivamente do banco

	function active_btn_deleted_advert() {
		
		$(".btn-edit-deleted-advert").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_advert_data",
				dataType: "json",
				data: {"id_advert": $(this).attr("id_advert")},
				success: function(response) {
					clearErrors();
					$("#form_advert")[0].reset();
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					$("#advert_img_path").attr("src", response["img"]["advert_img_path"]);
					$("#modal_advert").modal();
					dt_deleted_advert.ajax.reload();
				}
			})
		});

		//Ativa o botão para excluir definitivamente anúncios deletados pelo usuário

		$(".btn-exclude-advert").click(function(){
			
			id_advert = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja excluir definitivamente esse anúncio?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_exclude_advert_data",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_deleted_advert.ajax.reload();
						}
					})
				}
			})

		});

		//Ativa o botão para excluir definitivamente todos os anúncios

		$("#btn_exclude_all").click(function(){
			
			swal({
				title: "Atenção!",
				text: "Deseja excluir definitivamente todos os anúncios?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_exclude_all_advert_data",
						dataType: "json",
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_deleted_advert.ajax.reload();
						}
					})
				}
			})

		});

		//Ativa o botão para restaurar anúncios deletados (não excluídos definitivamente)

		$(".btn-recycle-advert").click(function(){
			
			id_advert = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja reativar esse anúncio?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_recycle_advert_data",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_deleted_advert.ajax.reload();
						}
					})
				}
			})

		});
	}

	//Ativa listagem de anúncios deletados e não excluídos do banco

	var dt_deleted_advert = $("#dt_deleted_adverts").DataTable({
		"oLanguage": DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": BASE_URL + "restrict/ajax_list_deleted_advert",
			"type": "POST",
		},
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		"drawCallback": function() {
			active_btn_deleted_advert();
		}
	});

	
	function active_btn_user() {
		
		$(".btn-edit-user").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_user_data",
				dataType: "json",
				data: {"id_user": $(this).attr("id_user")},
				success: function(response) {
					clearErrors();
					$("#form_user")[0].reset();
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					$("#modal_user").modal();
				}
			})
		});

		$(".btn-del-user").click(function(){
			
			user_id = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja deletar esse usuário?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_delete_user_data",
						dataType: "json",
						data: {"id_user": user_id.attr("id_user")},
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_user.ajax.reload();
						}
					})
				}
			})

		});
	}

	var dt_user = $("#dt_users").DataTable({
		"oLanguage": DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": BASE_URL + "restrict/ajax_list_user",
			"type": "POST",
		},
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		"drawCallback": function() {
			active_btn_user();
		}
	});


})
