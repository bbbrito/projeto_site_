const NUM_PHOTOS = 5;

$(function(){

	// Exibir Modais
	$("#btn_add_advert").click(function(){
		clearErrors();
		$("#form_advert")[0].reset();
		//$("#advert_img_path").attr("src", "");
		$("#image-list").html("");
		$("#advert_img_path").html("");
		$("#btn_upload_advert_img").html("");
		$("#response").val("");
		$(".btn.btn-block.btn-info").attr('style', 'display: block');        
  		$("#add-image").attr('style', 'display: none');
		formdata = new FormData();
		$("#modal_advert").modal();
	});

	$("#btn_new_advert").click(function(){
		clearErrors();
		$("#form_advert")[0].reset();
		//$("#advert_img_path").attr("src", "");
		$("#modal_advert").modal();
	});

	$("#btn_new_advert_on_deleteds").click(function(){
		clearErrors();
		$("#form_advert")[0].reset();
		//$("#advert_img_path").attr("src", "");
		$("#modal_advert").modal();
	});

	$("#btn_add_user").click(function(){
		clearErrors();
		$("#form_user")[0].reset();
		$("#modal_user").modal();
	});

	/*$("#btn_upload_advert_img").change(function(){
		uploadImg($(this), $("#advert_img_view"), $("#advert_img"));
	});*/

	$(function(){
 		$('[data-toggle="popover"]').popover({html: true});
	});

	$(function(){
        $("#zip_code").blur(function(){
            var cep = $('#zip_code').val();
            if (cep == '') {
                alert('Informe o CEP antes de continuar');
                //$('#zip_code').focus();
                return false;
            }

            $.ajax({
				type: "POST",
				url: BASE_URL + "restrict/consulta",
				dataType: "json",
				data: {"cep": cep},
				beforeSend: function() {
					clearErrors();
					$("#zip_code").siblings(".help-block").html(loadingImg("Verificando..."));
				},
				success: function(response) {
					clearErrors();
					if (response["status"]) {
						$('#city').val(response["zip_code"]["cidade"]);
	                	$('#state').val(response["zip_code"]["uf"]);
					} else {
						$("#zip_code").siblings(".help-block").html(response["error_list"]);
						$('#city').val("");
	                	$('#state').val("");
					}								
				}
			})
        });
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
					swal("Sucesso!","Seu anúncio estará ativo em breve!", "success");
					dt_advert.ajax.reload();
					dt_new_advert.ajax.reload();
					dt_deleted_advert.ajax.reload();
					$.ajax({
						url: BASE_URL + "restrict/send_new_advert_email",						
					})
				} else {
					showErrorsModal(response["error_list"]);
				}
			}
		})

		return false;
	});

	$(document).on("input", "#advert_description", function () {
	    var limite = 512;
	    var caracteresDigitados = $(this).val().length;
	    var caracteresRestantes = limite - caracteresDigitados;

	    $(".caracteres").text(caracteresRestantes);
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
							$.ajax({
								type: "POST",
								data: "email="+response["confirmation"]["email_user"]+"&token="+response["confirmation"]["token"],
								url: BASE_URL + "restrict/send_new_user_email",
								success: function(response) {
									clearErrors();									
									swal("Verifique seu e-mail!","Siga as instruções no e-mail que enviamos a "+response["confirmation"]["email_user"]+" para confirmação de cadastro. Faça isso imediatamente, porque o link no e-mail expirará em breve.", "success");
								}
							})
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

	//Ativa edição de anúncios ativos (ativada após carregar o datatable)

	function active_btn_advert() {
		
		$(".btn-edit-advert").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_advert_data",
				dataType: "json",
				data: {"id_advert": $(this).attr("id_advert")},
				beforeSend: function() {
						clearErrors();
						$("#image-list").html("");
						$("#advert_img_path").html("");
						$("#btn_upload_advert_img").html("");
						$("#advert_img").val("");
						formdata = new FormData();
					},
				success: function(response) {
					clearErrors();
					$("#form_advert")[0].reset();
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					//$("#advert_img").attr("src", response["img"]["advert_img_view_thumb"]);
					//$("#advert_img_view").html(response["img"]["advert_img_view_thumb"]);
					$("#advert_img").val(response["img"]["img_path_temp"]);
					$.each(response["img"]["img_path_temp"], function(index, value) {
						showUplodedItem(value);
					});
					$("#modal_advert").modal();
					dt_advert.ajax.reload();
					dt_new_advert.ajax.reload();
					dt_deleted_advert.ajax.reload();
				}
			})
			$.ajax({
				url: BASE_URL + "restrict/send_new_advert_email",						
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
							swal("Sucesso!", "Anúncio excluído com sucesso", "success");
							dt_advert.ajax.reload();
							dt_new_advert.ajax.reload();
							dt_deleted_advert.ajax.reload();
						}
					});
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/send_delete_advert_email",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},						
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
		"responsive": true,
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
				beforeSend: function() {
						clearErrors();
						$("#image-list").html("");
						$("#advert_img_path").html("");
						$("#btn_upload_advert_img").html("");
						$("#advert_img").val("");
						formdata = new FormData();
					},
				success: function(response) {
					clearErrors();
					$("#form_advert")[0].reset();
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					//$("#advert_img").attr("src", response["img"]["advert_img_view_thumb"]);
					//$("#advert_img_view").html(response["img"]["advert_img_view_thumb"]);
					$("#advert_img").val(response["img"]["img_path_temp"]);
					$.each(response["img"]["img_path_temp"], function(index, value) {
						showUplodedItem(value);
					});
					$("#modal_advert").modal();
					dt_advert.ajax.reload();
					dt_new_advert.ajax.reload();
					dt_deleted_advert.ajax.reload();
				}
			})
		});

		//Ativa o botão para excluir definitivamente anúncios em aprovação

		$(".btn-exclude-new-advert").click(function(){
			
			id_advert = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja reprovar e excluir definitivamente esse anúncio?",
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
						url: BASE_URL + "restrict/ajax_disapproved_advert_data",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
						success: function(response) {
							clearErrors();
							$.ajax({
								type: "POST",
								data: "title="+response["title"]+"&to="+response["to"],
								url: BASE_URL + "restrict/send_disapproved_advert_email",
								success: function(response) {
									clearErrors();									
									swal("Sucesso!", "Anúncio excluído definitivamente!", "success");
									dt_advert.ajax.reload();
									dt_new_advert.ajax.reload();
									dt_deleted_advert.ajax.reload();
								}
							})
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
							clearErrors();
							swal("Sucesso!", "Anúncio aprovado com sucesso", "success");
							dt_advert.ajax.reload();
							dt_new_advert.ajax.reload();
							dt_deleted_advert.ajax.reload();
						}
					});
					
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/send_approve_advert_email",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")}
						
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
						data: $(this).serialize(),
						success: function(response) {
							clearErrors();
							$.ajax({
								type: "POST",
								data: "titles="+response["titles"]+"&tos="+response["tos"],
								url: BASE_URL + "restrict/send_approve_all_advert_email",
								success: function(response) {
									clearErrors();									
									swal("Sucesso!","Anúncios aprovados com sucesso!", "success");
									dt_advert.ajax.reload();
									dt_new_advert.ajax.reload();
									dt_deleted_advert.ajax.reload();
								}
							})								

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
		"responsive": true,
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


	//Ativa edição de anúncios deletados pelo usuário, mas não excluídos definitivamente do banco

	function active_btn_deleted_advert() {
		
		$(".btn-edit-deleted-advert").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_advert_data",
				dataType: "json",
				data: {"id_advert": $(this).attr("id_advert")},
				beforeSend: function() {
						clearErrors();
						$("#image-list").html("");
						$("#advert_img_path").html("");
						$("#btn_upload_advert_img").html("");
						$("#advert_img").val("");
						formdata = new FormData();
					},
				success: function(response) {
					clearErrors();
					$("#form_advert")[0].reset();
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					//$("#advert_img").attr("src", response["img"]["advert_img_view_thumb"]);
					//$("#advert_img_view").html(response["img"]["advert_img_view_thumb"]);
					$("#advert_img").val(response["img"]["img_path_temp"]);
					$.each(response["img"]["img_path_temp"], function(index, value) {
						showUplodedItem(value);
					});
					$("#modal_advert").modal();
					dt_advert.ajax.reload();
					dt_new_advert.ajax.reload();
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
							clearErrors();
							$.ajax({
								type: "POST",
								data: "title="+response["title"]+"&to="+response["to"],
								url: BASE_URL + "restrict/send_exclude_advert_email",
								success: function(response) {
									clearErrors();									
									swal("Sucesso!", "Anúncio excluído definitivamente!", "success");
									dt_advert.ajax.reload();
									dt_new_advert.ajax.reload();
									dt_deleted_advert.ajax.reload();
								}
							})
						}
					})
					/*$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/send_exclude_advert_email",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
					})*/
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
							clearErrors();
							$.ajax({
								type: "POST",
								data: "titles="+response["titles"]+"&tos="+response["tos"],
								url: BASE_URL + "restrict/send_exclude_all_advert_email",
								success: function(response) {
									clearErrors();									
									swal("Sucesso!", "Anúncios excluídos definitivamente!", "success");
									dt_advert.ajax.reload();
									dt_new_advert.ajax.reload();
									dt_deleted_advert.ajax.reload();
								}
							})
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
							dt_advert.ajax.reload();
							dt_new_advert.ajax.reload();
							dt_deleted_advert.ajax.reload();
						}
					})
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/send_recycle_advert_email",
						dataType: "json",
						data: {"id_advert": id_advert.attr("id_advert")},
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
		"responsive": true,
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
					//*$("#advert_img_path").attr("src", response["img"]["advert_img_path"]);
					//$("#advert_img_path").html(response["img"]["advert_img_path"]);
					//$("#modal_advert").modal();
					$("#modal_user").modal();
				}
			})
		});

		//Ativa o botão para deletar anúncios e retirar visualização dos ativos

		$(".btn-del-user").click(function(){
			
			id_user = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja banir esse usuário para sempre?",
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
						data: {"id_user": id_user.attr("id_user")},
						success: function(response) {
							swal("Sucesso!", "Usuário excluído com sucesso", "success");
							dt_user.ajax.reload();
						}
					})
				}
			})

		});
	}

	//Ativa listagem de usuários (carregar o datatable)

	var dt_user = $("#dt_users").DataTable({
		"oLanguage": DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"responsive": true,
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


	/*if (window.File && window.FileList && window.FileReader) {
	    $("#btn_upload_advert_img").on("change", function(e) {
	    	var files = e.target.files,
	        filesLength = files.length;

	      	for (i = 0; i < filesLength; i++) {
	        	var f = files[i]
	        	var fileReader = new FileReader();  

		        /*$("<input class=\"remove\" id=\"advert_img" + [i] + "\" />" +
		            "<br/>").insertAfter("#btn_upload_advert_img");
		         $("#advert_img" + [i]).val(response["img_path"][i]);*/

		        /*fileReader.onload = (function(e) {
		          var file = e.target;

				  $("<span class=\"pip\">" +
		            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
		            "<br/><span class=\"remove\">Remove image</span>" +
		            "</span>").insertAfter("#btn_upload_advert_img");

				  $(".remove").click(function(){
		            $(this).parent(".pip").remove();
		            $("#advert_img" + i).remove();
					});

				  $("<input class=\"remove\" id=\"advert_img\" />" +
		            "<br/>").insertAfter("#btn_upload_advert_img");
		         	
		        $("#advert_img").val(response["img_path"][i]);
  
				});

				fileReader.readAsDataURL(f);


	    	var src_before = $("#advert_img_view").attr("src");
			var files = $("#btn_upload_advert_img")[0].files;
			form_data = new FormData();

			for (var count = 0; count < files.length; count++) {
				form_data.append("files[]", files[count]);
			}

		    $.ajax({
					url: BASE_URL + "restrict/ajax_import_image",
					dataType: "json",
					type: "POST",
					data: form_data,
					contentType: false,
					cache: false,
					processData: false,	
					beforeSend: function() {
						clearErrors();
						$("#advert_img").siblings(".help-block").html(loadingImg("Carregando imagem..."));
					},
					success: function(response) {
						clearErrors();
						if(response["status"]) {
							//$("#advert_img_view").html(response["img_view"]);
							//$("#advert_img").val(response["img_path"]);

							/*img_path = response["img_path"];

							private function arrayFiles(img_path) {
								file_array = array();
						        file_count = count(img_path);
						        for (var i = 0; i < file_count; i++) {
						            foreach (img_path as path) {
						                file_array[i][path] = response["img_path"][i];
						            }
						        }

						        return file_array;
					    	}*/


							/*var files = e.target.files,
	        				filesLength = files.length;

					      	for (i = 0; i < filesLength; i++) {
					        	var f = files[i]
					        	var fileReader = new FileReader();  

						        /*$("<input class=\"remove\" id=\"advert_img" + [i] + "\" />" +
						            "<br/>").insertAfter("#btn_upload_advert_img");
						         $("#advert_img" + [i]).val(response["img_path"][i]);*/

						        /*fileReader.onload = (function(e) {
						          var file = e.target;

								  $("<span class=\"pip\">" +
						            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
						            "<br/><span class=\"remove\">Remove image</span>" +
						            "</span>").insertAfter("#btn_upload_advert_img");

								  $(".remove").click(function(){
						            $(this).parent(".pip").remove();
						            $("#advert_img" + i).remove();
									});

								  $("<input class=\"remove\" id=\"advert_img\" />" +
						            "<br/>").insertAfter("#btn_upload_advert_img");
						         	
						        $("#advert_img").val(response["img_path"][i]);
		          
		        				});

		        				fileReader.readAsDataURL(f);*/
		        				
		        				/*$("<input class=\"remove\" id=\"advert_img" + i + "\" />" +
						            "<br/>").insertAfter("#btn_upload_advert_img");
						         	
						        $("#advert_img" + i).val(response["img_path"][i]);*/
						        



		      				/*}
						} else {
							$("#advert_img_view").attr("src", src_before);
							$("#advert_img").siblings(".help-block").html(response["error"]);
						}
					},
					error: function() {
						$("#advert_img_view").attr("src", src_before);
					}
			});

	    });

	} else {
	    alert("Your browser doesn't support to File API")
	}*/

	var input = document.getElementById("btn_upload_advert_img"),
        formdata = false;

    /*$(document).on("click", ".categories-list.flex-container li", function() {

    function tempInput(path){
        var input_temp = new Array();

		
    }*/

    function showUplodedItem(source){
        var list = document.getElementById('image-list'),
            li = document.createElement('li'),
            img = document.createElement('img');

        img.src = source;
        img.className = "imageThumb";
      
      	$(".btn.btn-block.btn-info").attr('style', 'display: none');//oculta botão de envio de foto       
  		$("#add-image").attr('style', 'display: inline');
        list.appendChild(li);
        li.appendChild(img);
		
    }

    if (window.FormData) {
        formdata = new FormData();
        document.getElementById('btn').style.display = "none";
    }

    input.addEventListener('change', function(evt){
        document.getElementById('advert_img_path').innerHTML = "Enviando Imagens.."

        var i = 0, len = this.files.length, img, render, f;

        for(; i < len; i++){
            f = this.files[i];
            if(!!f.type.match(/image.*/)){
                if(window.FileReader){
                    render = new FileReader();
                    
		        	render.onloadend = function(e){
                        showUplodedItem(e.target.result, f.fileName);
                    };
                    render.readAsDataURL(f);
                }
                if(formdata){
                    formdata.append('files[]', f);
                }
            }
        }

        if(formdata){
            $.ajax({
                url: BASE_URL + "restrict/ajax_import_image",
				dataType: "json",
				type: "POST",
				data: formdata,
				contentType: false,
				cache: false,
				processData: false,	
				/*beforeSend: function() {
					clearErrors();
					document.getElementById('advert_img_path').siblings(".help-block").html(loadingImg("Carregando imagem..."));
				},*/
				success: function(response) {
					clearErrors();
					if(response["status"]) {
						document.getElementById('advert_img_path').innerHTML = response["img_path"];
						$("#advert_img").val(response["img_path"]);
					} else {
						$("#advert_img").siblings(".help-block").html(response["error"]);						
						//$("#advert_img_path").siblings(".help-block").html(response["error"]);
						$("#image-list").html("");
						$("#advert_img_path").html("");
						$("#btn_upload_advert_img").html("");
						$("#advert_img").val("");
						$(".btn.btn-block.btn-info").attr('style', 'display: flex');        
				  		$("#add-image").attr('style', 'display: none');
						formdata = new FormData();

					}
				},
				error: function() {
					$("#image-list").html("");
					$("#advert_img_path").html("");
					$("#btn_upload_advert_img").html("");
					$("#response").val("");
					$(".btn.btn-block.btn-info").attr('style', 'display: flex');        
			  		$("#add-image").attr('style', 'display: none');
					formdata = new FormData();;
				}
            });
        }
    }, false);


	//Substitui o botão submit para o envio de fotos
	    $("#add-image").click(function(){
			$("#btn_upload_advert_img").trigger("click");
		});



})
