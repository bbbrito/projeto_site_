$(document).on("click", ".btn_advert_view_count", function() {
	var id_advert = $(this);
	$.ajax({
		type: "POST",
		url: BASE_URL + "home/ajax_views_count",
		dataType: "json",
		data: {"id_advert": id_advert.attr("id_advert")},
	})
})
