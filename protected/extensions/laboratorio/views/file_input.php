<div class="form-group">
  <label class="control-label col-md-4"><?php echo $label; ?></label>
  <div class="controls col-md-8">
      <div class="fileupload fileupload-new" data-provides="fileupload">
        <span class="btn btn-white btn-file">
        <span class="fileupload-new"><i class="icon-paper-clip"></i> Examinar</span>
        <span class="fileupload-exists"><i class="icon-undo"></i> Cambiar</span>
        
        <input id="yt<?php echo $model_name; ?>_<?php echo $campo; ?>" type="hidden" name="<?php echo $model_name; ?>[<?php echo $campo; ?>]" value="">
        <input id="<?php echo $model_name; ?>_<?php echo $campo; ?>" type="file" name="<?php echo $model_name; ?>[<?php echo $campo; ?>]">

        </span>
          <span class="fileupload-preview" style="margin-left:5px;"></span>
          <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
      </div>
  </div>
</div>