<section style="min-height: calc(100vh - 193px)" class="light-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6 text-center">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h3>Cadastro de nova senha</h3>			
							<form id="form_password">

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">

											<div class="input-group">
												<div class="input-group-addon">
													<span class="glyphicon glyphicon-envelope"></span>
												</div>
												<input type="text" id="email_new_password" name="email_new_password" autocomplete="username" class="form-control" maxlength="100" value="<?php echo $this->uri->segment(3);?>" readonly required>
											</div>
																							
											<input type="text" id="token_new_password" name="token_new_password" value="<?php echo $this->uri->segment(4);?>" autocomplete="username" required hidden>
											
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
												<input type="password" placeholder="Digite a nova senha..." id="new_password_user" name="new_password_user" class="form-control" autocomplete="cc-csc" maxlength="255">
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
												<input type="password" placeholder="Confirme a nova senha..." id="new_password_user_confirm" name="new_password_user_confirm" class="form-control" autocomplete="cc-csc" maxlength="255">				
											</div>
											<span class="help-block"></span>
										</div>									
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group text-center">
											<button type="submit" id="btn_new_password" class="btn btn-primary">
											<i class="icon-save"></i>&nbsp;&nbsp;Salvar
										</button>
										</div>
										<span class="help-block"></span>							
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
