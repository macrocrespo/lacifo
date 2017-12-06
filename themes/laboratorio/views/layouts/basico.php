    <?php $this->beginContent('//layouts/main'); ?>

    <section id="main-content">
      <section class="wrapper no-padding-mobile">
          <?php echo $content; ?>
      </section>
        
      <footer class="site-footer">
          <div class="text-center">
              LACIFOWEB <?php echo date('Y'); ?> © Crespo - Montenegro
              <a href="#" class="go-top">
                  <i class="icon-angle-up"></i>
              </a>
          </div>
      </footer>  
    </section>

    <?php $this->endContent(); ?>

    <?php $theme_url = Yii::app()->theme->baseUrl.'/'; ?>
    <input type="hidden" id="base_url" value="<?php echo Yii::app()->request->baseUrl; ?>/" />
    <input type="hidden" id="theme_url" value="<?php echo $theme_url; ?>" />

    <!-- js placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>assets/bootstrap-daterangepicker/date.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/jquery.scrollTo.min.js"></script>

    <!--custom switch-->
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/bootstrap-switch.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/jquery.tagsinput.js"></script>
    
    <!--custom checkbox & radio-->
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/ga.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/_laboratorio.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/common-scripts.js"></script>

    <!--script for this page-->
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/form-component.js"></script>

  </body>
</html>

