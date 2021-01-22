//Adiciona número de visualizações do anúncio
$(document).on("click", ".btn_advert_view_count", function() {
	$.ajax({
		type: "POST",
		url: BASE_URL + "home/ajax_views_count",
		dataType: "json",
		data: {"id_advert": $(this).attr("id_advert")},
	})
});

//Envia as fotos para o carrossel no modal
$(document).on("click", ".btn_advert_view_count", function() {
	data = $(this).attr("id_advert");
	$.ajax({
		type: "POST",
		url: BASE_URL + "home/ajax_get_advert_data_modal",
		dataType: "json",
		data: {"id_advert": $(this).attr("id_advert")},
		success: function(response) {
					clearErrors();

					$(".carousel-indicators").html('');
					$(".carousel-inner").html('');

					$("#faqui-carousel-"+data+" .carousel-indicators").html(response["img"]["advert_data_slide_to"]);
					$("#faqui-carousel-"+data+" .carousel-inner").html(response["img"]["advert_img_path_item"]);

			        $(".carousel-indicators li:first").addClass("active");
			        $(".carousel-inner .item:first").addClass("active");

			        $('.carousel').carousel();
				}
	})
});

//Envia o id da cidade para filtrar resultados


// Ativar o estado e mostrar lista de cidades
/*$(document).on("click", ".categories-list.flex-container li", function() {
		id_state = $(this).attr("id_state");
		console.log(id_state);

		$.ajax({
      type: "POST",
      url: BASE_URL + "home/ajax_list_city_data",
      dataType: "json",
      data: "page=&id_state="+id_state,     
			//data: {"id_state": $(this).attr("id_state")},
			beforeSend: function(){
        $(".loading").show();
      },
      success: function(response) {
      	clearErrors();
      	$("#id_cities").html("");
        $("#city_list_"+id_state+" .dropdown.slab2").html(response["input"]);
        //$("#id_cities").html(response["input"]);
      }
    });

    var menu = $(this).children().children('.dropdown.slab2');
    var submenu = $(this).children('.list-slider-container');
		//var divSubmenu = $(this).siblings('.list-slider-container');
		var submenuCities = $(this).children().children('.dropdown.slab2').children();
   	//var active = $(this).parent('.categories-list.flex-container li');

	  if(menu.length > 0 && menu.is(':hidden')){
	    $(".categories-list.flex-container li").removeClass('selected active'); //remove a marcação de todos
	    $(this).addClass('selected active'); //adiciona marcação em um só elemento
	    $(".list-slider-container").attr('style', 'display: none;');
	    submenu.attr('style', 'display: block;');
	    $(".dropdown.slab2 li").removeClass('item-visible'); //remove a marcação de todos
	    submenuCities.addClass('item-visible'); //adiciona marcação em um só elemento
	    //$('.dropdown.slab2').slideUp(); //recolhe os elementos do submenu
	    //menu.slideDown(); //mostra os itens do submenu
	    //$("#menu ul").not($(".categories-list.flex-container li")).slideDown();

	     /*if(submenu.hasClass('.dropdown.slab2') && menu.length > 0){
     		$("#menu ul").not($(".categories-list.flex-container li")).slideUp();
      }*/

	    /*var submenuCities = $('.categories-list.flex-container li').children().children('.dropdown.slab2').children('.slider-item.item-visible');

			var quantCities = submenuCities.length;

			var quantScreen = Math.ceil(quantCities / 12);/*pegando a quantidade de itens e dividindo pela quantidade que eu quero que apareça na tela*/
					
			/*if(quantScreen <= 1){
				const arrowRightElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div');
				arrowRightElement.style.visibility = 'hidden';

				const arrowRightElementSvg = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg');
				arrowRightElementSvg.style.visibility = 'hidden';
									
				const arrowRightElementPath = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg > path');
				arrowRightElementPath.style.visibility = 'hidden';
			}
		}

});*/

$(document).on("click", ".categories-list.flex-container li", function() {

	var menu = $(this).children().children('.dropdown.slab2');
	var submenu = $(this).children('.list-slider-container');
	var submenuCities = $(this).children().children('.dropdown.slab2').children();
 
  if(menu.length > 0 && menu.is(':hidden')){
    $(".categories-list.flex-container li").removeClass('selected active'); //remove a marcação de todos
    $(this).addClass('selected active'); //adiciona marcação em um só elemento
    $(".list-slider-container").attr('style', 'display: none;');
    submenu.attr('style', 'display: block;');
    //$(".dropdown.slab2 li").removeClass('item-visible'); //remove a marcação de todos
    //submenuCities.addClass('item-visible'); //adiciona marcação em um só elemento
    //$('.dropdown.slab2').slideUp(); //recolhe os elementos do submenu
    //menu.slideDown(); //mostra os itens do submenu

    var submenuCities = $('.categories-list.flex-container li').children().children('.dropdown.slab2').children('.slider-item.item-visible');
		var quantCities = submenuCities.length;
		var quantScreen = Math.ceil(quantCities / 12);/*pegando a quantidade de itens e dividindo pela quantidade que eu quero que apareça na tela*/
				
		if(quantScreen <= 1){
			const arrowRightElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div');
			arrowRightElement.style.visibility = 'hidden';

			const arrowRightElementSvg = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg');
			arrowRightElementSvg.style.visibility = 'hidden';
								
			const arrowRightElementPath = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg > path');
			arrowRightElementPath.style.visibility = 'hidden';
		}
	}
	/*if(!submenu.hasClass('.dropdown.slab2') && menu.length == 0){
	   $(".categories-list.flex-container li").removeClass('selected active');
	   $(this).addClass('selected active');
	   //display.attr('style', 'display: block');
	   //$('.dropdown.slab2').slideUp();
	}*/

});

// Mostrar submenu de cidades
function stateFilter(id_state){
  $.ajax({
    type: "POST",
    url: BASE_URL + "home/ajax_list_city_data",
    data: "id_state="+id_state,
    beforeSend: function(){
      $(".loading").show();
    },
    success: function(html) {
      $("#city_list_"+id_state).html(html);
      $(".loading").fadeOut("slow");
    }
  });
}

// Ativar a cidade
$(document).on("click", ".dropdown.slab2 li", function(event) {
		$(".categories-list-categ li").removeClass('selected'); //remove a marcação de todos
  	$(".dropdown.slab2 li").removeClass('selected'); //remove a marcação de todos
  	$(this).addClass('selected'); //adiciona marcação em um só elemento
  	cityFilter();
  	event.stopImmediatePropagation();
 });

function cityFilter(page_num){
  page_num = page_num ? page_num: 0;
  var sortBy = $("#sortBy").val();
  //console.log(sortBy);

  if (document.querySelector(".slider-item.selected") != null) {
    var id_city = document.querySelector(".slider-item.selected").id;   
    console.log(id_city);
	} else {
		var id_city = "";
	}

  if (document.querySelector(".slider-item2.selected") != null) {
    var category = document.querySelector(".slider-item2.selected").id;   
    console.log(category);
  } else {
  	var category = "";
  } 

  $.ajax({
    type: "POST",
    url: BASE_URL + "home/ajax_filter_city_data/" + page_num,
    data: "page="+page_num+"&id_city="+id_city+"&category="+category+"&sortBy="+sortBy,
    beforeSend: function(){
      $(".loading").show();
    },
    success: function(html) {
    	$("#advertList").html("");
        $("#advertList").html(html);
        $(".loading").fadeOut("slow");
    }
  });
}

$(function(){
	$(".slider-control.left.slab2").click(function(){
	    var arrow2 = $(this).parent().children(".slider-control.left.slab2").children().children();

	    const arrowRightElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div');
		arrowRightElement.style.visibility = 'visible';

		const arrowRightElementSvg = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg');
		arrowRightElementSvg.style.visibility = 'visible';
					
		const arrowRightElementPath = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg > path');
		arrowRightElementPath.style.visibility = 'visible';
				
	    if(arrow2.length > 0){
	    	const arrowLeftElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > ul');
			var selectedItem = arrowLeftElement.style.getPropertyValue('--selected-item');	
			selectedItem = selectedItem - 1;
			arrowLeftElement.style.setProperty('--selected-item', selectedItem);
			if(selectedItem == 0){
				const arrowLeftElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.left.slab2 > div');
				arrowLeftElement.style.visibility = 'hidden';

				const arrowLeftElementSvg = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.left.slab2 > div > svg');
				arrowLeftElementSvg.style.visibility = 'hidden';
	
				const arrowLeftElementPath = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.left.slab2 > div > svg > path');
	    		arrowLeftElementPath.style.visibility = 'hidden';
			}
			
	    }
	       
	   });
});

$(function(){
	$(".slider-control.right.slab2").click(function(){
	    var arrow = $(this).parent().children(".slider-control.right.slab2").children().children();

	    const arrowLeftElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.left.slab2 > div');
		arrowLeftElement.style.visibility = 'hidden';

		const arrowLeftElementSvg = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.left.slab2 > div > svg');
		arrowLeftElementSvg.style.visibility = 'visible';
					
		const arrowLeftElementPath = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.left.slab2 > div > svg > path');
		arrowLeftElementPath.style.visibility = 'visible';
				
	    if(arrow.length > 0){
	    	const arrowRightElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > ul');
			var selectedItem = getComputedStyle(arrowRightElement,null).getPropertyValue('--selected-item');	
			selectedItem = parseInt(selectedItem) + 1;

			var submenuCities = $('.categories-list.flex-container li').children().children('.dropdown.slab2').children('.slider-item.item-visible');
			var quantCities = submenuCities.length;
			var quantScreen = Math.ceil(quantCities / 12) - 1;/*pegando a quantidade de itens e dividindo pela quantidade que eu quero que apareça na tela*/
		
			if(quantScreen >= selectedItem){
				arrowRightElement.style.setProperty('--selected-item', selectedItem);
				console.log(selectedItem);
				if(quantScreen == selectedItem){
					const arrowRightElement = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div');
					arrowRightElement.style.visibility = 'hidden';

					const arrowRightElementSvg = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg');
					arrowRightElementSvg.style.visibility = 'hidden';
						
					const arrowRightElementPath = document.querySelector('#navbar-main > div.navbar-container > ul > li.item.category.slab1-text.selected.active > div > div.slider-control.right.slab2 > div > svg > path');
				    arrowRightElementPath.style.visibility = 'hidden';
				}
			}
			
	    }
	       
	   });
});

//Altera cabeçalho categorias
$(function(){
	$(".categories-list-categ li").click(function(event){
		
    	$(".categories-list-categ li").removeClass('selected'); //remove a marcação de todos
    	$(this).addClass('selected'); //adiciona marcação em um só elemento
    	cityFilter();
    	event.stopImmediatePropagation();
   });
});



//Controla a rolagem das categorias
$(function(){
	$(".slider-control.right-categ").click(function(){

    //var arrow = $(this).parent().children().children(".slider-item");
    var arrow = $(this).parent().children(".slider-control.left-categ").children().children();
    //var arrowB = $(this).parent().children(".slider-control.left-categ").children().children().children();
    if(arrow.length > 0){
	    const arrowLeft = document.querySelector('#navbar-main > div.list-slider-container-categ > ul');
		arrowLeft.style.setProperty('--selected-item', '1');
		
		const arrowLeftElement = document.querySelector('#navbar-main > div.list-slider-container-categ > div.slider-control.left-categ > div');
		arrowLeftElement.style.visibility = 'visible';

		const arrowLeftElementSvg = document.querySelector('#navbar-main > div.list-slider-container-categ > div.slider-control.left-categ > div > svg');
		arrowLeftElementSvg.style.visibility = 'visible';
		
		const arrowLeftElementPath = document.querySelector('#navbar-main > div.list-slider-container-categ > div.slider-control.left-categ > div > svg > path');
    	arrowLeftElementPath.style.visibility = 'visible';
    }
       
   });
});

$(function(){
	$(".slider-control.left-categ").click(function(){

    //var arrow = $(this).parent().children().children(".slider-item");
    var arrow = $(this).parent().children(".slider-control.left-categ").children().children();
    //var arrowB = $(this).parent().children(".slider-control.left-categ").children().children().children();
    if(arrow.length > 0){
	    const arrowLeft = document.querySelector('#navbar-main > div.list-slider-container-categ > ul');
		arrowLeft.style.setProperty('--selected-item', '0');
		
		const arrowLeftElement = document.querySelector('#navbar-main > div.list-slider-container-categ > div.slider-control.left-categ > div');
		arrowLeftElement.style.visibility = 'hidden';

		const arrowLeftElementSvg = document.querySelector('#navbar-main > div.list-slider-container-categ > div.slider-control.left-categ > div > svg');
		arrowLeftElementSvg.style.visibility = 'hidden';
		
		const arrowLeftElementPath = document.querySelector('#navbar-main > div.list-slider-container-categ > div.slider-control.left-categ > div > svg > path');
    	arrowLeftElementPath.style.visibility = 'hidden';
    }
       
   });
});

/*$("#contactForm").submit(function() {
		var nome = $("#name").val();
		console.log(nome);
		var email = $("#email").val();
		console.log(email);
		var mensagem = $("#message").val();
		console.log(mensagem);

		var regex = /\S+@\S+\.\S+/;
        // test email
        if( !regex.test( email ) )
        {
            alert("Oops! O email informado é inválido!");
            return false;
        }

		
		$.ajax({
			type: "POST",
			url: BASE_URL + "home/ajax_send_email",
			//data: "name="+nome+"&email="+email+"&message="+mensagem,
			data: $("#contactForm").serialize(),
			dataType: "json",
			/*beforeSend: function() {
				clearErrors();
				$("#btn_send_email").siblings(".help-block").html(loadingImg("Verificando..."));
			},*/
			/*success: function(response) {
				clearErrors();
				console.log(response);
				if (response["status"]) {
					swal("Sucesso!","E-mail enviado com sucesso!", "success");
				} else {
					showErrorsModal(response["error_list"]);
					
				}
			}
		})

		return false;
	});*/
