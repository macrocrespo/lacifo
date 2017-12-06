<!DOCTYPE html>
<html lang="es-AR">
<?php echo $this->renderPartial('//layouts/_head'); ?>

      <!--main content goes here-->
      <?php echo $content; ?>

    <?php $base_url = Yii::app()->theme->baseUrl.'/'; ?>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo $base_url; ?>js/jquery.js"></script>
    <script src="<?php echo $base_url; ?>js/bootstrap.js"></script>
  </body>
</html>