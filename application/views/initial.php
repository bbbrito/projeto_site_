<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Frete Aqui</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Site Frete Aqui para fretes e carretos" />
	<meta name="keywords" content="fretes, carretos, veículos, ônibus, micro-ônibus, microonibus, van, kombi, perua, moto, moto boy, rodoviário, executivo, urbano, caminhão, caminhonete, camionete, carroceria, baú, passageiro, furgão, carga, automóvel" />
	<meta name="author" content="Frete Aqui" />

  <!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<!-- <meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" /> -->

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<!--<link rel="shortcut icon" href="favicon.ico"> -->

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'>

	<!-- Animate.css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/simple-line-icons.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/owl.theme.default.min.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.css">



	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css">


	<!-- Modernizr JS -->
	<script src="<?php echo base_url(); ?>public/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->


	<?php if (isset($styles)) {
		foreach ($styles as $style_name){
			$href = base_url() . "public/css/" . $style_name; ?>
			<link href="<?=$href?>" rel="stylesheet">
		<?php }
	} ?>

	</head>
	<body>
	<header role="banner" id="faqui-header">
			<div class="container">
				<!-- <div class="row"> -->
			<nav class="navbar navbar-default">
		        <div class="navbar-header">
		        	<!-- Mobile Toggle Menu Button -->
					<a href="#" class="js-faqui-nav-toggle faqui-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
		          	<a class="navbar-brand" href="<?php echo base_url(); ?>home">Frete Aqui</a> 
		        </div>
			<?php 
      		if (!$this->session->userdata("id_user")) { ?>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav navbar-right">
		            <li><a href="<?php echo base_url(); ?>home"><span>Anúncios</span></a></li>
		            <li><a href="<?php echo base_url(); ?>initial"><span>Página Inicial</span></a></li>
			        <li><a href="<?php echo base_url(); ?>initial/#about" data-nav-section="about"><span>Sobre</span></a></li>
			        <li><a href="<?php echo base_url(); ?>#services" data-nav-section="services"><span>Quero Fretar</span></a></li>
			        <li><a href="<?php echo base_url(); ?>#features" data-nav-section="features"><span>Quero Anunciar</span></a></li>
			        <!---<li><a href="<?php //echo base_url(); ?>#testimonials" data-nav-section="testimonials"><span>Depoimentos</span></a></li>-->
			        <!---<li><a href="<?php //echo base_url(); ?>#pricing" data-nav-section="pricing"><span>Preços</span></a></li>-->
			        <li><a href="<?php echo base_url(); ?>restrict"><span>Login</span></a></li>
			        <li><a href="<?php echo base_url(); ?>restrict"><span>Anuncie Grátis</span></a></li>
			      </ul>
			    </div>
		        <?php } else { ?>
					<div id="navbar" class="navbar-collapse collapse">
			          <ul class="nav navbar-nav navbar-right">
			            <li class="active"><a href="<?php echo base_url(); ?>home"><span>Anúncios</span></a></li>
			            <li><a href="<?php echo base_url(); ?>initial"><span>Página Inicial</span></a></li>
			            <li><a href="<?php echo base_url(); ?>initial/#about" data-nav-section="about"><span>Sobre</span></a></li>
			            <li><a href="<?php echo base_url(); ?>#services" data-nav-section="services"><span>Quero Fretar</span></a></li>
			            <li><a href="<?php echo base_url(); ?>#features" data-nav-section="features"><span>Quero Anunciar</span></a></li>
			            <!---<li><a href="<?php //echo base_url(); ?>#testimonials" data-nav-section="testimonials"><span>Depoimentos</span></a></li>-->
			            <!---<li><a href="<?php //echo base_url(); ?>#pricing" data-nav-section="pricing"><span>Preços</span></a></li>-->
			            <li><a href="<?php echo base_url(); ?>restrict"><span>Anuncie Grátis</span></a></li>

					    <?php
					      $user = $_SESSION['username'];
					    ?>

					    <li><a href="<?php echo base_url(); ?>restrict"><i class="icon-user"><?=$user?></i></a></li>
					    <li><a class="item login square-button" href="restrict/logoff"><i class="icon-sign-out" data-toggle="tooltip" data-placement="auto top" title="Sair"></i></a></li>					      
			          </ul>

			        </div>
			   <?php } ?>
			   </nav>
			  <!-- </div> -->
			</div>
	</header>
	
	<div id="slider" data-section="nome">
		<div class="owl-carousel owl-carousel-fullwidth">
			<!-- You may change the background color here. #352f44 -->
		    <!--<div class="item" style="background: #000000;"> -->
		    <div class="item" style="background-image:url(public/images/slide_3.jpg)">
		    	<div class="container" style="position: relative;">
		    		<div class="row">
					    <div class="col-md-8 col-md-offset-2 text-center">
			    			<div class="faqui-owl-text-wrap">
						    	<div class="faqui-owl-text">
						    		<h1 class="faqui-lead to-animate">Ônibus, Micro-ônibus, Caminhões, Caminhonetes, Motos e muito mais</h1>
									<h2 class="faqui-sub-lead to-animate">Com apenas alguns cliques, encontre seu veículo para fretes/carretos de escola, igreja, praia, balneário, funeral, city tour, retiro espiritual, mudança, entrega etc. no  <a href="<?php echo base_url(); ?>home">Frete Aqui</a></h3>
									<p class="to-animate-2"><a href="<?php echo base_url(); ?>home" class="btn btn-primary btn-lg">Ver anúncios</a></p>
						    	</div>
						    </div>
					    </div>

		    		</div>
		    	</div>
		    </div>
			<!-- You may change the background color here.  -->
		    <!--<div class="item" style="background: #38569f;"> -->
		    <div class="item" style="background-image:url(public/images/slide_4.jpg)">
		    	<div class="container" style="position: relative;">
		    		<div class="row">
		    			<div class="col-md-8 col-md-offset-2 text-center">
			    			<div class="faqui-owl-text-wrap">
						    	<div class="faqui-owl-text">
						    		<h1 class="faqui-lead to-animate">Praticidade</h1>
									<h2 class="faqui-sub-lead to-animate">Você recebe uma lista de veículos disponíveis para frete/carreto e escolhe a melhor oferta para você, negociando direto com a empresa, transportadora, agenciador ou proprietário do veículo no <a href="<?php echo base_url(); ?>home">Frete Aqui</a></h3>
									<p class="to-animate-2"><a href="<?php echo base_url(); ?>home" class="btn btn-primary btn-lg">Ver anúncios</a></p>
						    	</div>
						    </div>
					    </div>
		    		</div>
		    	</div>
		    </div>

		    <div class="item" style="background-image:url(public/images/slide_5.jpg)">
		    	<div class="overlay"></div>
		    	<div class="container" style="position: relative;">
		    		<div class="row">
		    			<div class="col-md-8 col-md-offset-2 text-center">
		    				<div class="faqui-owl-text-wrap">
						    	<div class="faqui-owl-text">
		    						<h1 class="faqui-lead to-animate">Anuncie agora 100% grátis!</h1>
									<h2 class="faqui-sub-lead to-animate">Aumente seu faturamento com carretos, fretes, mudanças, entregas, viagens e turismo. Anuncie seu veículo no  <a href="<?php echo base_url(); ?>restrict">Frete Aqui</a></h3>
									<p class="to-animate-2"><a href="<?php echo base_url(); ?>restrict"class="btn btn-primary btn-lg">Anuncie Grátis</a></p>
								</div>
							</div>
		    			</div>
		    		</div>
		    	</div>
		    </div>

		</div>
	</div>
	
	<div id="faqui-about-us" data-section="about">
		<div class="container">
			<div class="row row-bottom-padded-lg" id="about-us">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Quem Somos</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 to-animate">
							<h3>Somos um canal de anúncios de veículos para fretes e carretos, e que conecta anunciantes a seus clientes de forma gratuita.</h3>
						</div>
					</div>
				</div>
				<div class="col-md-8 to-animate">
					<img src="<?php echo base_url(); ?>public/images/img_1.jpg" class="img-responsive img-rounded" alt="Veículo para fretes ou carretos">
				</div>
				<div class="col-md-4 to-animate">
					<h2>Como começamos?</h2>
					<p>Percebemos a dificuldade de se encontrar veículos para fretes em nossa cidade, pois muitos proprietários desses veículos não possuíam opções baratas ou gratuitas para anunciar seus serviços. </p>
					<p>Foi então que tivemos a ideia de fornecer esta plataforma para anunciantes e clientes se conectarem de forma gratuita.</p>
					<p><a href="<?php echo base_url(); ?>home" class="btn btn-primary">Veja nossos anúncios</a></p>
				</div>
			</div>
			<!---<div class="row" id="team">
				<div class="col-md-12 section-heading text-center to-animate">
					<h2>Team</h2>
				</div>
				<div class="col-md-12">
					<div class="row row-bottom-padded-lg">
						<div class="col-md-4 text-center to-animate">
							<div class="person">
								<img src="<?php //echo base_url(); ?>public/images/person2.jpg" class="img-responsive img-rounded" alt="Person">
								<h3 class="name">John Doe</h3>
								<div class="position">Web Developer</div>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics.</p>
								<ul class="social social-circle">
									<li><a href="#"><i class="icon-twitter"></i></a></li>
									<li><a href="#"><i class="icon-linkedin"></i></a></li>
									<li><a href="#"><i class="icon-instagram"></i></a></li>
									<li><a href="#"><i class="icon-github"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-4 text-center to-animate">
							<div class="person">
								<img src="<?php //echo base_url(); ?>public/images/person3.jpg" class="img-responsive img-rounded" alt="Person">
								<h3 class="name">Rob Smith</h3>
								<div class="position">Web Designer</div>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics.</p>
								<ul class="social social-circle">
									<li><a href="#"><i class="icon-twitter"></i></a></li>
									<li><a href="#"><i class="icon-linkedin"></i></a></li>
									<li><a href="#"><i class="icon-instagram"></i></a></li>
									<li><a href="#"><i class="icon-dribbble"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-4 text-center to-animate">
							<div class="person">
								<img src="<?php //echo base_url(); ?>public/images/person4.jpg" class="img-responsive img-rounded" alt="Person">
								<h3 class="name">John Doe</h3>
								<div class="position">Photographer</div>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics.</p>
								<ul class="social social-circle">
									<li><a href="#"><i class="icon-twitter"></i></a></li>
									<li><a href="#"><i class="icon-linkedin"></i></a></li>
									<li><a href="#"><i class="icon-instagram"></i></a></li>
									<li><a href="#"><i class="icon-github"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>-->
		</div>
	</div>
	<div id="faqui-our-services" data-section="services">
		<div class="container">
			<div class="row row-bottom-padded-sm">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Quer Fretar?</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 to-animate">
							<h3>Aqui você encontra uma variedade de veículos para seu frete/carreto.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-1"><span><i class="icon-mustache"></i></span></div>
						<h3>100% grátis</h3>
						<p>Nossa ferramenta é 100% gratuita para acessar, e você negocia seu frete diretamente com o proprietário através dos contatos fornecidos no anúncio.</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-4"><span><i class="icon-heart"></i></span></div>
						<h3>Ama viajar?</h3>
						<p>Aqui você encontra veículos para fazer aquele passeio entre família e amigos.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-2"><span><i class="icon-screen-desktop"></i></span></div>
						<h3>+ Comodidade?</h3>
						<p>Com apenas alguns cliques, encontre seu veículo para frete/carreto pelo computador ou smartphone.</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-5"><span><i class="icon-rocket"></i></span></div>
						<h3>Rapidez?</h3>
						<p>Encontre o que procura de forma rápida.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-3"><span><i class="icon-eye"></i></span></div>
						<h3>Procurando algo?</h3>
						<p>Encontre aqui sem precisar pesquisar em vários sites.</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-6"><span><i class="icon-user"></i></span></div>
						<h3>Dúvidas ou sugestões?</h3>
						<p>Queremos muito ouvir você. Fale conosco através dos nossos canais como Facebook e e-mail.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-4 single-animate animate-features-3">
						<a href="<?php echo base_url(); ?>home" class="btn btn-primary btn-block">Ver Anúncios</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="faqui-features" data-section="features">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="single-animate animate-features-1">Quer Anunciar?</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 single-animate animate-features-2">
							<h3>Está no lugar certo. Anuncie seu veículo no Frete Aqui.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-bottom-padded-sm">
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 faqui-service to-animate">
					<div class="faqui-icon"><i class="icon-present"></i></div>
					<div class="faqui-desc">
						<h3>100% Grátis</h3>
						<p>Você não paga nada para anunciar. </p>
					</div>	
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 faqui-service to-animate">
					<div class="faqui-icon"><i class="icon-eye"></i></div>
					<div class="faqui-desc">
						<h3>Visibilidade</h3>
						<p>Quem não anuncia se esconde. Aqui seus serviços terão mais visibilidade. </p>
					</div>
				</div>
				<div class="clearfix visible-sm-block visible-xs-block"></div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 faqui-service to-animate">
					<div class="faqui-icon"><i class="icon-crop"></i></div>
					<div class="faqui-desc">
						<h3>Aumente seu faturamento</h3>
						<p>Anuncie carretos, fretes, mudanças, entregas, viagens e turismo. </p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 faqui-service to-animate">
					<div class="faqui-icon"><i class="icon-speedometer"></i></div>
					<div class="faqui-desc">
						<h3>Rapidez</h3>
						<p>Seu anúncio é publicado em poucas horas. </p>
					</div>	
				</div>
				<div class="clearfix visible-sm-block visible-xs-block"></div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 faqui-service to-animate">
					<div class="faqui-icon"><i class="icon-heart"></i></div>
					<div class="faqui-desc">
						<h3>Tem paixão pelo que faz?</h3>
						<p>Nós ajudamos você a tornar sua paixão visível a seus clientes. </p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 faqui-service to-animate">
					<div class="faqui-icon"><i class="icon-umbrella"></i></div>
					<div class="faqui-desc">
						<h3>Começando agora com seu veículo?</h3>
						<p>Nós damos a você a cobertura para fazer seus anúncios de forma gratuita. </p>
					</div>
				</div>
				<div class="clearfix visible-sm-block visible-xs-block"></div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4 single-animate animate-features-3">
					<a href="<?php echo base_url();?>restrict" class="btn btn-primary btn-block">Anunciar</a>
				</div>
			</div>
		</div>
	</div>

	<!---<div id="faqui-testimonials" data-section="testimonials">		
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Happy Clients Says...</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext to-animate">
							<h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box-testimony to-animate">
						<blockquote>
							<span class="quote"><span><i class="icon-quote-left"></i></span></span>
							<p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
						</blockquote>
						<p class="author">John Doe, CEO <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span></p>
					</div>
					
				</div>
				<div class="col-md-4">
					<div class="box-testimony to-animate">
						<blockquote>
							<span class="quote"><span><i class="icon-quote-left"></i></span></span>
							<p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.&rdquo;</p>
						</blockquote>
						<p class="author">John Doe, CEO <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span></p>
					</div>
					
					
				</div>
				<div class="col-md-4">
					<div class="box-testimony to-animate">
						<blockquote>
							<span class="quote"><span><i class="icon-quote-left"></i></span></span>
							<p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
						</blockquote>
						<p class="author">John Doe, Founder <a href="#">FREEHTML5.co</a> <span class="subtext">Creative Director</span></p>
					</div>
					
				</div>
			</div>
		</div>
	</div>-->

	<!---<div id="faqui-pricing" data-section="pricing">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="single-animate animate-pricing-1">Pricing</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext single-animate animate-pricing-2">
							<h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<div class="price-box to-animate">
						<h2 class="pricing-plan">Starter</h2>
						<div class="price"><sup class="currency">$</sup>7<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>10 projects</li>
							<li>20 Pages</li>
							<li>20 Emails</li>
							<li>100 Images</li>
						</ul>
						<a href="#" class="btn btn-default btn-sm">Get started</a>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="price-box to-animate">
						<h2 class="pricing-plan">Regular</h2>
						<div class="price"><sup class="currency">$</sup>19<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>15 projects</li>
							<li>40 Pages</li>
							<li>40 Emails</li>
							<li>200 Images</li>
						</ul>
						<a href="#" class="btn btn-default btn-sm">Get started</a>
					</div>
				</div>
				<div class="clearfix visible-sm-block"></div>
				<div class="col-md-3 col-sm-6 to-animate">
					<div class="price-box popular">
						<div class="popular-text">Best value</div>
						<h2 class="pricing-plan">Plus</h2>
						<div class="price"><sup class="currency">$</sup>79<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>Unlimitted projects</li>
							<li>100 Pages</li>
							<li>100 Emails</li>
							<li>700 Images</li>
						</ul>
						<a href="#" class="btn btn-primary btn-sm">Get started</a>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="price-box to-animate">
						<h2 class="pricing-plan">Enterprise</h2>
						<div class="price"><sup class="currency">$</sup>125<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>Unlimitted projects</li>
							<li>Unlimitted Pages</li>
							<li>Unlimitted Emails</li>
							<li>Unlimitted Images</li>
						</ul>
						<a href="#" class="btn btn-default btn-sm">Get started</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>-->

	<!---<div id="faqui-press" data-section="press">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="single-animate animate-press-1">Press Releases</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext single-animate animate-press-2">
							<h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">-->
					<!-- Press Item -->
					<!---<div class="faqui-press-item to-animate">
						<div class="faqui-press-img" style="background-image: url(images/img_7.jpg)">
						</div>
						<div class="faqui-press-text">
							<h3 class="h2 faqui-press-title">Simplicity <span class="faqui-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>-->
					<!-- Press Item -->
				<!---</div>

				<div class="col-md-6">-->
					<!-- Press Item -->
					<!---<div class="faqui-press-item to-animate">
						<div class="faqui-press-img" style="background-image: url(images/img_8.jpg)">
						</div>
						<div class="faqui-press-text">
							<h3 class="h2 faqui-press-title">Versatile <span class="faqui-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>-->
					<!-- Press Item -->
				<!---</div>
				
				<div class="col-md-6">-->
					<!-- Press Item -->
					<!---<div class="faqui-press-item to-animate">
						<div class="faqui-press-img" style="background-image: url(images/img_9.jpg);">
						</div>
						<div class="faqui-press-text">
							<h3 class="h2 faqui-press-title">Aesthetic <span class="faqui-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>-->
					<!-- Press Item -->
				<!---</div>

				<div class="col-md-6">-->
					<!-- Press Item -->
					<!---<div class="faqui-press-item to-animate">
						<div class="faqui-press-img" style="background-image: url(images/img_10.jpg);">
						</div>
						<div class="faqui-press-text">
							<h3 class="h2 faqui-press-title">Creative <span class="faqui-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>-->
					<!-- Press Item -->
				<!---</div>

			</div>
		</div>
	</div>-->
