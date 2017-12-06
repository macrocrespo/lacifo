<div class="tasi-form form-horizontal">
    <div class="form-group ">
        <?php if ($label != '') { ?>
        <label for="<?php echo $model_name; ?>_<?php echo $campo; ?>" class="col-sm-12 control-label required">
            <?php echo $label; ?>
        </label>
        <br /><br />
        <?php } ?>
        <div class="col-sm-12">
            <textarea id="<?php echo $model_name; ?>_<?php echo $campo; ?>" class="form-control ckeditor" name="<?php echo $model_name; ?>[<?php echo $campo; ?>]" rows="6"><?php echo $value; ?></textarea>
        </div>
    </div>
</div>