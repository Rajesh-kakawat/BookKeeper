
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($test) ) {
    $test = (array)$test;
}
$id = isset($test['id']) ? $test['id'] : '';
?>
<div class="admin-box">
    <h3>test</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('test_abc') ? 'error' : ''; ?>">
            <?php echo form_label('abc', 'test_abc', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="test_abc" type="text" name="test_abc"  value="<?php echo set_value('test_abc', isset($test['test_abc']) ? $test['test_abc'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('test_abc'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('test_qwerty1') ? 'error' : ''; ?>">
            <?php echo form_label('qwerty', 'test_qwerty1', array('class' => "control-label") ); ?>
            <div class='controls'>
            <label class="checkbox" for="test_qwerty1">
            <input type="checkbox" id="test_qwerty1" name="test_qwerty1" value="1" <?php echo (isset($test['test_qwerty1']) && $test['test_qwerty1'] == 1) ? 'checked="checked"' : set_checkbox('test_qwerty1', 1); ?>>
            <span class="help-inline"><?php echo form_error('test_qwerty1'); ?></span>
            </label>

        </div>

        </div>
        <div class="control-group <?php echo form_error('test_qwerty') ? 'error' : ''; ?>">
            <?php echo form_label('qwerty', 'test_qwerty', array('class' => "control-label") ); ?>
            <div class='controls'>
            <label class="checkbox" for="test_qwerty">
            <input type="checkbox" id="test_qwerty" name="test_qwerty" value="1" <?php echo (isset($test['test_qwerty']) && $test['test_qwerty'] == 1) ? 'checked="checked"' : set_checkbox('test_qwerty', 1); ?>>
            <span class="help-inline"><?php echo form_error('test_qwerty'); ?></span>
            </label>

        </div>

        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Edit test" />
            or <?php echo anchor(SITE_AREA .'/content/test', lang('test_cancel'), 'class="btn btn-warning"'); ?>
            

    <?php if ($this->auth->has_permission('Test.Content.Delete')) : ?>

            or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php echo lang('test_delete_confirm'); ?>')">
            <i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('test_delete_record'); ?>
            </button>

    <?php endif; ?>


        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
