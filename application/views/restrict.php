	<header role="banner" id="faqui-header">
			<div class="container">
				<!-- <div class="row"> -->
			    <nav class="navbar navbar-default">
		        <div class="navbar-header">
		        	<!-- Mobile Toggle Menu Button -->
					<a href="#" class="js-faqui-nav-toggle faqui-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
		          	<a class="navbar-brand-restrict" href="<?php echo base_url(); ?>home">Frete Aqui</a> 
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav navbar-right">
		            <li><a href="<?php echo base_url(); ?>home"><span>Anúncios</span></a></li>
		            <li><a href="<?php echo base_url(); ?>initial"><span>Página Inicial</span></a></li>
		            <!---<li><a href="<?php //echo base_url(); ?>#testimonials" data-nav-section="testimonials"><span>Depoimentos</span></a></li>-->
		            <!---<li><a href="<?php //echo base_url(); ?>#pricing" data-nav-section="pricing"><span>Preços</span></a></li>-->
		          </ul>
		        </div>
			    </nav>
			  <!-- </div> -->
			</div>
	</header>
<br><br><br>
<section style="min-height: calc(100vh - 93px)" class="light-bg">
	
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6 text-center">
				<div class="section-title">
					<h2>Área Restrita</h2>					
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-offset-4 col-lg-4 text-center">
				<div class="form-group">
					<a id="btn_your_user" class="btn btn-link" id_user="<?=$id_user?>" data-toggle="tooltip" data-placement="auto top" title="Clique para alterar seus dados de usuário e senha"><i class="icon-user">Editar</i></a>
					<a class="btn btn-link" href="restrict/logoff"><i class="icon-sign-out" data-toggle="tooltip" data-placement="auto top" title="Clique para sair">Sair</i></a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container">

		<?php 
			if ($this->session->userdata("id_user")) {
					$array_id_user = array("id_user" => $this->session->userdata("id_user"));
					$id_user = $array_id_user["id_user"];
					unset($array_id_user["id_user"]);

					if($id_user == 1){?>
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab_adverts" role="tab" data-toggle="tab">Ativos</a></li>
							<li><a href="#tab_new_adverts" role="tab" data-toggle="tab">Em Aprovação</a></li>
							<li><a href="#tab_deleted_adverts" role="tab" data-toggle="tab">Excluídos</a></li>
							<li><a href="#tab_users" role="tab" data-toggle="tab">Usuários</a></li>
						</ul>
					<?php } else{?>
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab_adverts" role="tab" data-toggle="tab">Meus Anúncios</a></li>
							<li><a href="#tab_new_adverts" role="tab" data-toggle="tab">Em Aprovação</a></li>
							<li><a href="#tab_deleted_adverts" role="tab" data-toggle="tab">Excluídos</a></li>
						</ul>
					<?php }
				}?>

			<!--<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_adverts" role="tab" data-toggle="tab">Ativos</a></li>
				<li><a href="#tab_new_adverts" role="tab" data-toggle="tab">Em Aprovação</a></li>
				<li><a href="#tab_users" role="tab" data-toggle="tab">Usuários</a></li>
			</ul>-->


		<div class="tab-content">
			<?php
			if($id_user == 1){?>
			<div id="tab_adverts" class="tab-pane active">
				<div class="container-fluid">
					<h2 class="text-center"><strong>Gerenciar Anúncios</strong></h2>
					<a id="btn_add_advert" class="btn btn-primary">Criar Anúncio</a>
					<div style="width: 100%; padding-left: -10px; border: 1px solid blue;">
    				<div class="table-responsive">
						<table id="dt_adverts" class="table table-striped table-bordered" >
							<thead>
								<tr class="tableheader">
									<th class="dt-center">Título</th>
									<th class="dt-center no-sort">Imagem</th>
									<th class="dt-center">Estado</th>
									<th class="dt-center">Data de Publicação</th>
									<th class="dt-center">Visitas</th>
									<th class="dt-center">Usuário</th>	
									<th class="dt-center no-sort">Ações</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					</div>
				</div>
			</div>
			<?php } else{?>
			<div id="tab_adverts" class="tab-pane active">
				<div class="container-fluid">
					<h2 class="text-center"><strong>Gerenciar Anúncios</strong></h2>
					<a id="btn_add_advert" class="btn btn-primary">Criar Anúncio</a>
					<div style="width: 100%; padding-left: -10px; border: 1px solid blue;">
    				<div class="table-responsive">
						<table id="dt_adverts" class="table table-striped table-bordered" >
							<thead>
								<tr class="tableheader">
									<th class="dt-center">Título</th>
									<th class="dt-center no-sort">Imagem</th>
									<th class="dt-center">Estado</th>
									<th class="dt-center">Data de Publicação</th>
									<th class="dt-center">Visitas</th>	
									<th class="dt-center no-sort">Ações</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					</div>
				</div>
			</div>
		<?php } ?>

			<?php
			if($id_user == 1){?>
				<div id="tab_new_adverts" class="tab-pane">
					<div class="container-fluid">
						<h2 class="text-center"><strong>Gerenciar Novos Anúncios</strong></h2>
						<a id="btn_approve_all" class="btn btn-primary">Aprovar Tudo</a>
						<div style="width: 100%; padding-left: -10px; border: 1px solid blue;">
    					<div class="table-responsive">
						<table id="dt_new_adverts" class="table table-striped table-bordered">
							<thead>
								<tr class="tableheader">
									<th class="dt-center">Título</th>
									<th class="dt-center no-sort">Imagem</th>
									<th class="dt-center">Estado</th>
									<th class="no-sort">Descrição</th>
									<th class="dt-center">Data de Publicação</th>
									<th class="dt-center">Usuário</th>	
									<th class="dt-center no-sort">Ações</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						</div>
						</div>
					</div>
				</div>

			<?php } else{?>
				<div id="tab_new_adverts" class="tab-pane">
					<div class="container-fluid">
						<h2 class="text-center"><strong>Gerenciar Novos Anúncios</strong></h2>
						<a id="btn_new_advert" class="btn btn-primary">Criar Anúncio</a>
						<div style="width: 100%; padding-left: -10px; border: 1px solid blue;">
    					<div class="table-responsive">
						<table id="dt_new_adverts" class="table table-striped table-bordered">
							<thead>
								<tr class="tableheader">
									<th class="dt-center">Título</th>
									<th class="dt-center no-sort">Imagem</th>
									<th class="dt-center">Estado</th>
									<th class="no-sort">Descrição</th>
									<th class="dt-center">Data de Publicação</th>	
									<th class="dt-center no-sort">Ações</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						</div>
						</div>	
					</div>
				</div>
			<?php
				}?>
			
			<?php
			if($id_user == 1){?>
				<div id="tab_deleted_adverts" class="tab-pane">
					<div class="container-fluid">
						<h2 class="text-center"><strong>Anúncios Excluídos</strong></h2>
						<a id="btn_exclude_all" class="btn btn-danger">Excluir Tudo</a>
						<div style="width: 100%; padding-left: -10px; border: 1px solid blue;">
    					<div class="table-responsive">
						<table id="dt_deleted_adverts" class="table table-striped table-bordered">
							<thead>
								<tr class="tableheader">
									<th class="dt-center">Título</th>
									<th class="dt-center no-sort">Imagem</th>
									<th class="dt-center">Estado</th>
									<th class="no-sort">Descrição</th>
									<th class="dt-center">Data de Publicação</th>
									<th class="dt-center no-sort">Status de Aprovação</th>
									<th class="dt-center no-sort">Visitas</th>
									<th class="dt-center no-sort">Usuário</th>
									<th class="dt-center no-sort">Ações</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						</div>
						</div>
					</div>
				</div>


			<?php } else{?>
				<div id="tab_deleted_adverts" class="tab-pane">
					<div class="container-fluid">
						<h2 class="text-center"><strong>Anúncios Excluídos</strong></h2>
						<a id="btn_new_advert_on_deleteds" class="btn btn-primary">Criar Anúncio</a>
						<div style="width: 100%; padding-left: -10px; border: 1px solid blue;">
    					<div class="table-responsive">
						<table id="dt_deleted_adverts" class="table table-striped table-bordered">
							<thead>
								<tr class="tableheader">
									<th class="dt-center">Título</th>
									<th class="dt-center no-sort">Imagem</th>
									<th class="dt-center">Estado</th>
									<th class="no-sort">Descrição</th>
									<th class="dt-center">Data de Publicação</th>
									<th class="dt-center no-sort">Visitas</th>
									<th class="dt-center no-sort">Reativar Anúncio</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						</div>
						</div>
					</div>
				</div>
			<?php
				}?>
			
			<div id="tab_users" class="tab-pane">
				<div class="container-fluid">
					<h2 class="text-center"><strong>Gerenciar Usuários</strong></h2>
					<a id="btn_add_user" class="btn btn-primary">Adicionar Usuário</a>
					<div style="width: 100%; padding-left: -10px; border: 1px solid blue;">
    				<div class="table-responsive">
					<table id="dt_users" class="table table-striped table-bordered">
						<thead>
							<tr class="tableheader">
								<th class="dt-center">login</th>
								<th class="dt-center">email</th>
								<th class="dt-center">Data de Cadastro</th>
								<th class="dt-center">Situação</th>
								<th class="dt-center no-sort">Ações</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div id="modal_advert" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h4 class="modal-title">Cadastro de Anúncio</h4>
			</div>

			<div class="modal-body">
				<form id="form_advert">

					<input id="id_advert" name="id_advert" hidden>
					
					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Título do Anúncio</label>
						<div class="col-lg-12">
							<input id="advert_title" name="advert_title" class="form-control" maxlength="100" pattern="[a-zA-Z0-9]+[\s]{0,}/?[\wà-úÀ-Ú ]*" required="required" placeholder="Digite o título somente com letras">
							<span class="help-block"></span>
						</div>
					</div>
				
					<!-- <div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Imagem</label>
						<div class="col-lg-12">
							<img id="advert_img_path" src="" class="img-responsive img-thumbnail" style="max-width: 100px; max-height: 100px"> 
							<ul id="advert_img_view">

							</ul>
							<label class="btn btn-block btn-info">
								<i class="icon-upload"></i>&nbsp;+
								 <input type="file" style="display: none" id="btn_upload_advert_img" name="btn_upload_advert_img[]" multiple accept="image/*" >
								
							</label> -->

							<!-- <input id="advert_img" name="advert_img" /> -->
							<!-- <span class="help-block"></span>
						</div>
					</div> -->

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Imagem</label>
						<div class="col-lg-12">
							<label class="btn btn-block btn-info">
								<i class="icon-upload"></i>&nbsp;Enviar fotos
								<input id="btn_upload_advert_img" type="file" name="btn_upload_advert_img" multiple accept="image/*"/> 
     							<button type="submit" class="btn btn-primary" id="btn"></button>

							</label>
							<div id="advert_img_path"></div>					        

							<div id="form_img">
					        	<div id="add-image" class="hoverzoom" aria-label="Carregar outra imagem" style="display: none">
					        		<img src="<?php echo base_url(); ?>public/images/img_11.png" class="imageThumb" alt="Carregar outra imagem">
					        	</div>

					        	<ul id="image-list">				        	

					        	</ul>

					        </div>
					    	
					        

					        <div style="clear:both;"></div>

					        <input id="advert_img" name="advert_img"/>
							<span class="help-block"></span>
						</div>				        
				    </div>
					


					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Categoria do Veículo</label>
						<div class="col-lg-12">
							<select id="category" name="category" class="form-control" maxlength="45">
							<option disabled selected>Escolher...</option>
							<option>Ônibus Executivo</option>
							<option>Ônibus Rodoviário</option>
							<option>Ônibus Urbano</option>
							<option>Micro-ônibus Executivo</option>
							<option>Micro-ônibus Rodoviário</option>
							<option>Micro-ônibus Urbano</option>
							<option>Van Passageiro</option>
							<option>Van Furgão Carga</option>
							<option>Kombi Passageiro</option>
							<option>Kombi Carga</option>							
							<option>Caminhão Baú</option>
							<option>Caminhão Carroceria</option>
							<option>Caminhonete Baú</option>
							<option>Caminhonete Carroceria</option>
							<option>Automóvel Utilitário</option>
							<option>Moto Boy</option>
							</select>
							<span class="help-block"></span>
						</div>
					</div>					

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">CEP</label>
						<div class="col-lg-12">
							<input type="text" id="zip_code" name="zip_code" class="form-control" maxlength="8" autofocus required placeholder="Somente os números do CEP">
							<span class="help-block"></span>
						</div>
					</div>

					<!-- <div class="form-group">
						<div class="col-lg-12">
							<button id="btn_consulta" class="btn btn-success">Verificar CEP</button>
						</div>                        
                    </div> -->

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Cidade</label>
						<div class="col-lg-12">
							<input type="text" id="city" name="city" class="form-control" readonly required maxlength="20">
							<span class="help-block"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Estado</label>
						<div class="col-lg-12">							
							<input type="text" name="state" id="state" class="form-control" readonly required size="2" maxlength="8"/>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Telefone para Contato</label>
						<div class="col-lg-12">
							<input type="text" name="phone" id="phone" class="form-control" onkeypress="$(this).mask('(00) 00000-0000')">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Descreva seu anúncio</label>
						<div>
						<label class="col-xs-6 col-md-6 control-label">
							<a href="#" data-toggle="popover" title="Ex.: WTur" data-content="
							Ex.: Viaje com segurança e garantia.<br>
							Fretes para passeios (pic-nic), fretes para eventos etc.<br>
							<br>
							Fone1: (DDD) 9XXX-XXXX<br>
							Fone2: (DDD) 9XXX-XXXX (Whatsapp)<br>
							<br>
							Formas de pagamento:<br>
							Ex.: Dinheiro e cartões Visa e Mastercard<br>
							<br>
							Características:<br>
							Ex.: - XX lugares;<br>
							     - Som;<br>
							     - Ar condicionado etc.">Dicas
							</a>
	     				</label>
	     				</div>			
						<div class="col-lg-12">
							<textarea id="advert_description" name="advert_description" class="form-control" maxlength="512"></textarea>
							<span class="help-block"></span>
							<span class="caracteres">512</span> Restantes <br>
						</div>
					</div>

					<div class="form-group text-center">
						<button type="submit" id="btn_save_advert" class="btn btn-primary">
							<i class="icon-save"></i>&nbsp;&nbsp;Salvar
						</button>
						<span class="help-block"></span>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>


<div id="modal_user" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h4 class="modal-title">Cadastro de Usuário</h4>
			</div>
			<div class="modal-body">

				<form id="form_user">

					<input id="id_user" name="id_user" hidden>

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">Login</label>
						<div class="col-lg-12">
							<input type="text" placeholder="Digite o usuário..." id="login_user" name="login_user" autocomplete="username" class="form-control" maxlength="45">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-6 col-md-4 control-label">E-mail</label>
						<div class="col-lg-12">
							<input type="text" placeholder="Digite o e-mail..." id="email_user" name="email_user" autocomplete="username" class="form-control" maxlength="100">
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
						<label class="col-xs-6 col-md-4 control-label">Senha</label>
						<div class="col-lg-12">
							<input type="password" placeholder="Senha" id="password_user" name="password_user" autocomplete="new-password" class="form-control" maxlength="255">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
			            <label class="col-xs-6 col-md-4 control-label">Confirmar Senha</label>
			            <div class="col-lg-12">
			              <input type="password" id="password_user_confirm" name="password_user_confirm" autocomplete="new-password" class="form-control" maxlength="255">
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
