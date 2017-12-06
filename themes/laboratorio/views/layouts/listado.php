    <?php /* @var $this Controller */ ?>
    <?php $this->beginContent('//layouts/main'); ?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper no-padding-mobile">
          <!--main content goes here-->
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
    <!--main content end-->
    
    <div class="modal fade" id="title_in_modal" tabindex="-1" role="dialog" aria-labelledby="title_in_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endContent(); ?>
    
    <?php $theme_url = Yii::app()->theme->baseUrl.'/'; ?>
    <input type="hidden" id="base_url" value="<?php echo Yii::app()->request->baseUrl; ?>/" />
    <input type="hidden" id="theme_url" value="<?php echo $theme_url; ?>" />
    
    <!-- js placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/respond.min.js" ></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/jquery.scrollTo.min.js"></script>

    <!--common script for all pages-->
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/_laboratorio.js"></script>
    <script type="text/javascript" src="<?php echo $theme_url; ?>js/common-scripts.js"></script>

    <!--script for this page-->
    <script type="text/javascript" src="<?php echo $theme_url; ?>assets/advanced-datatable/media/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        var no_sort = $('#no_sort_columns').val();
        var no_sort_columns = [];
        if (no_sort !== undefined) {
            no_sort = no_sort.split(",");
            no_sort.forEach(function(element) {
                element = parseInt(element);
                no_sort_columns.push(element);
            });
        }
        $('.listado').dataTable({
            "bAutoWidth": false,
            "aoColumnDefs": [{ "bSortable": false, "aTargets": no_sort_columns }]
        });
    });
    </script>
  </body>
</html>