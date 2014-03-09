<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Student</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12"><?php echo Template::message();?></div>
</div>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i>
				Edit student
			</div>
			<div class="panel-body">
				<?php if (validation_errors()) : ?>
					<div class="alert alert-danger alert-dismissable ">
					  <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					  <h4 class="alert-heading">Please fix the following errors :</h4>
					 <?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>
				<?php
					if( isset($student) ) {
					    $student = (array)$student;
					}
					$id = isset($student['id']) ? $student['id'] : '';
				?>
					<?php echo form_open($this->uri->uri_string()); ?>
	       			<div class="form-group <?php echo form_error('student_name') ? 'has-error' : ''; ?>">
	            		<?php echo form_label('Name'. lang('bf_form_label_required'), 'student_name', array('class' => "control-label") ); ?>
	        			<input class="form-control"  id="student_name" type="text" name="student_name" maxlength="100" value="<?php echo set_value('student_name', isset($student['name']) ? $student['name'] : ''); ?>"  />
	    				<p class="help-block"><?php echo form_error('student_name'); ?></p>
	        		</div>
			        <div class="form-group <?php echo form_error('student_address') ? 'has-error' : ''; ?>">
			            <?php echo form_label('Address'. lang('bf_form_label_required'), 'student_address', array('class' => "control-label") ); ?>
			            <?php echo form_textarea( array( 'class'=>'form-control','name' => 'student_address', 'id' => 'student_address', 'rows' => '5', 'cols' => '80', 'value' => set_value('address', isset($student['address']) ? $student['address'] : '') ) )?>
			            <p class="help-block"><?php echo form_error('student_address'); ?></p>
			        </div>

			        <div class="form-group <?php echo form_error('student_course') ? 'has-error' : ''; ?>">
			            <?php echo form_label('Course'. lang('bf_form_label_required'), 'student_course', array('class' => "control-label") ); ?>
					        <input class="form-control"  id="student_course" type="text" name="student_course" maxlength="50" value="<?php echo set_value('course', isset($student['course']) ? $student['course'] : ''); ?>"  />
					        <p class="help-block"><?php echo form_error('student_course'); ?></p>
	        		</div>

	        		<div class="form-group <?php echo form_error('student_batch') ? 'has-error' : ''; ?>">
	            		<?php echo form_label('Batch', 'student_batch', array('class' => "control-label") ); ?>
				        <input class="form-control"  id="student_batch" type="text" name="student_batch" maxlength="50" value="<?php echo set_value('student_batch', isset($student['batch']) ? $student['batch'] : ''); ?>"  />
				        <p class="help-block"><?php echo form_error('student_batch'); ?></p>
			        </div>

	            	<input type="submit" name="save" class="btn btn-primary" value="Edit Student" />
		            or <?php echo anchor('/student', lang('student_cancel'), 'class="btn btn-warning"'); ?>
		            or <?php echo anchor('/student/delete/'.$id, '<i class="fa fa-trash-o">&nbsp;</i>&nbsp;'.lang('student_delete_record'), 'class="btn btn-danger" onclick="return confirm(\''.lang('student_delete_confirm').'\')"'); ?>
	    	<?php echo form_close(); ?>
		</div>
	</div>
</div>

