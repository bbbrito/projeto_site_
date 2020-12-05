	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>-->
	<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>-->
	<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>public/js/sweetalert2.all.min.js"></script>
	
	<!--<script src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>-->
	<!-- jQuery Easing -->
	<!--<script src="<?php echo base_url(); ?>public/js/jquery.easing.1.3.js"></script>-->
	<!-- Bootstrap -->
	<!--<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script> -->
	<!-- Waypoints -->
	<!--<script src="<?php echo base_url(); ?>public/js/jquery.waypoints.min.js"></script>-->
	<!-- Owl Carousel -->
	<!--<script src="<?php echo base_url(); ?>public/js/owl.carousel.min.js"></script>-->

	<!-- For demo purposes only styleswitcher ( You may delete this anytime ) -->
	<!--<script src="<?php echo base_url(); ?>public/js/jquery.style.switcher.js"></script>-->

	<!-- Main JS (Do not remove) -->
	<!--<script src="<?php echo base_url(); ?>public/js/main.js"></script> -->
	<script src="<?php echo base_url(); ?>public/js/ie10-viewport-bug-workaround.js"></script>

	<?php if (isset($scripts)) {
		foreach ($scripts as $script_name){
			$src = base_url() . "public/js/" . $script_name; ?>
			<script src="<?=$src?>"></script>
		<?php }
	} ?>

	</body>
</html>
