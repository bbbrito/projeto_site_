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
	<!--<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />  -->

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	
	<?php if (isset($styles)) {
		foreach ($styles as $style_name){
			$href = base_url() . "public/css/" . $style_name; ?>
			<link href="<?=$href?>" rel="stylesheet">
		<?php }
	} ?>

	</head>
