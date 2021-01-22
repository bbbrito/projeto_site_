<section id="advertList" class="light-bg">
  <div class="container">
    <div class="row">               
      <?php 
      if (!empty($adverts)) {
        foreach ($adverts as $advert) { ?>
          <div class="col-md-2">
            <div class="ot-portfolio-item">
              <figure class="effect-bubba">
                <div class="container-fluid" align="center">
                  <div class="row">
                    <div class="custom-container">
                      <div class="row">
                        <div class="col-10">
                        <?php 
                        $advert_img_path = explode(',', $advert["advert_img"]);
                        ?>
                          <img src="<?=base_url().$advert_img_path[0]?>" alt="img02" class="img-advert center-block">
                          <figcaption>
                            <?php
                            $advert_datetime_formated = $advert["advert_datetime"];
                            $advert_datetime_date = date('d/m/Y', strtotime($advert_datetime_formated));
                            $advert_datetime_hour = date('H:i', strtotime($advert_datetime_formated));
                            ?>
                            <h2><?=$advert["advert_title"]?></h2>
                            <p>Publicado em: <?=$advert_datetime_date ." às ". $advert_datetime_hour ."h"?></p>
                            <p>Clique Aqui</p>
                            <a href="#" class="btn_advert_view_count" id_advert="<?=$advert["id_advert"]?>" data-toggle="modal" data-target="#advert_<?=$advert["id_advert"]?>"></a>
                          </figcaption>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </figure>
            </div>
          </div>

          <div class="modal fade" id="advert_<?=$advert["id_advert"]?>" tabindex="-1" role="dialog" aria-labelledby="Modal-label-1">
            <div class="modal-dialog" role="document">
              <div class="modal-content">                          
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="X"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="Modal-label-1"><?=$advert["advert_title"]?></h4>
                </div>
                            
              <div class="modal-body">
                <div id="faqui-carousel-<?=$advert["id_advert"]?>" class="carousel slide">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">

                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">               
                  
                  </div>

                  <!-- Controls -->
                  <a class="left carousel-control" href="#faqui-carousel-<?=$advert["id_advert"]?>" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#faqui-carousel-<?=$advert["id_advert"]?>" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>

              <div class="modal-works"><span>Publicado em: <?=$advert_datetime_date ." às ". $advert_datetime_hour ."h"?></span></div>

              <div class="modal-works"><i class="glyphicon glyphicon-map-marker"></i><n><?=$advert["city"] ."-". $advert["state"]?></n></div>

              <div class="modal-works"><i class="glyphicon glyphicon-phone"></i><n><?=$advert["phone"]?></n></div>
              
                <p><pre><?=$advert["advert_description"]?></pre></p>
              </div>
                            
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
              </div>
            </div>
          </div>
        </div>
        <?php 
        } // end foreach
      } // end if 
      else { ?>
        <p> Nenhum anúncio desta categoria cadastrado. <a href="<?php echo base_url(); ?>restrict">Clique aqui</a> e seja o primeiro a anunciar!</p>
      <?php } ?>
    </div>
    <!-- Render pagination links -->
    <?php echo $this->ajax_pagination->create_links(); ?>
  </div><!-- end container -->
</section>
