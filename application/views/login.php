	<header role="banner" id="faqui-header">
			<div class="container">
				<!-- <div class="row"> -->
			    <nav class="navbar navbar-default">
		        <div class="navbar-header">
		        	<!-- Mobile Toggle Menu Button -->
					<a href="#" class="js-faqui-nav-toggle faqui-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
		          	<a class="navbar-brand" href="<?php echo base_url(); ?>home">Frete Aqui</a> 
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav navbar-right">
		            <li><a href="<?php echo base_url(); ?>home"><span>Anúncios</span></a></li>
		            <li><a href="<?php echo base_url(); ?>initial"><span>Página Inicial</span></a></li>
		            <!---<li><a href="<?php echo base_url(); ?>#testimonials" data-nav-section="testimonials"><span>Depoimentos</span></a></li>-->
		            <!---<li><a href="<?php echo base_url(); ?>#pricing" data-nav-section="pricing"><span>Preços</span></a></li>-->
		            <li class="active"><a href="<?php echo base_url(); ?>restrict"><span>Login</span></a></li>
		            <li><a href="<?php echo base_url(); ?>restrict"><span>Anunciar</span></a></li>
		          </ul>
		        </div>
			    </nav>
			  <!-- </div> -->
			</div>
	</header>
	
<br><br><br>
<section style="min-height: calc(100vh - 83px)" class="light-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6 text-center">
				<div class="row">
					<div class="col-lg-12 text-center">
						<div class="section-title">
							<h2>Login</h2>					
							<form id="login_form" method="post">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-addon">
													<span class="glyphicon glyphicon-user"></span>
												</div>
												<input type="text" placeholder="Usuário" id="username" name="username"class="form-control" autocomplete="cc-csc">
											</div>
											<span class="help-block"></span>
										</div>									
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-addon">
													<span class="glyphicon glyphicon-lock"></span>
												</div>
												<input type="password" placeholder="Senha" id="password" name="password"class="form-control" autocomplete="cc-csc">
											</div>	
										</div>									
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<button type="submit" id="btn_login" class="btn btn-block">Login</button>
										</div>
										<span class="help-block"></span>							
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-lg-12">
											<div class="text-center">
												<a id="btn_register" href="#" class="forgot-password">Não tenho cadastro</a>
												<p>Faça seu cadastro para anunciar. É rápido e fácil!</p>
											</div>
										</div>
									</div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div id="modal_user" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h4 class="modal-title">Cadastro de Usuário</h4>
			</div>
			<div class="modal-body">

				<form id="form_new_user">

					<input id="id_user" name="id_user" hidden>

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Login</label>
						<div class="col-lg-12">
							<input type="text" placeholder="Digite o usuário..." id="login_user" name="login_user" autocomplete="username" class="form-control" maxlengh="45">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">E-mail</label>
						<div class="col-lg-12">
							<input type="text" placeholder="Digite o e-mail..." id="email_user" name="email_user" autocomplete="username" class="form-control" maxlengh="100">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
            			<label class="col-xs-6 col-md-4 control-label">Confirmar E-mail</label>
			            <div class="col-lg-12">
			              <input type="text" placeholder="Confirmar e-mail" id="email_user_confirm" name="email_user_confirm" autocomplete="username" class="form-control" maxlength="100">
			              <span class="help-block"></span>
			            </div>
          			</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Senha</label>
						<div class="col-lg-10">
							<input type="password" placeholder="Senha" id="password_user" name="password_user" autocomplete="new-password" class="form-control">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
			            <label class="col-lg-2 control-label">Confirmar Senha</label>
			            <div class="col-lg-10">
			              <input type="password" id="password_user_confirm" name="password_user_confirm" autocomplete="new-password" class="form-control">
			              <span class="help-block"></span>
			            </div>
		          	</div>

					<div class="form-group text-center">
						<button type="submit" id="btn_save_user" class="btn btn-primary">
							<i class="icon-save"></i>&nbsp;&nbsp;Salvar
						</button>
							<span class="help-block"></span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

