<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Issue Book</h1>
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
				Issue book
			</div>
			<div class="panel-body">
				<?php if (validation_errors()) : ?>
					<div class="alert alert-danger alert-dismissable">
				  		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
				  		<h4 class="alert-heading">Please fix the following errors :</h4>
				 		<?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>
				<?php // Change the css classes to suit your needs
					if (isset($issue_book)) {
						$issue_book = (array)$issue_book;
					}
					$id = isset($issue_book['id']) ? $issue_book['id'] : '';
				?>
				<?php echo form_open($this -> uri -> uri_string()); ?>
					<div class="form-group <?php echo form_error('issue_book_book_id') ? 'has-error' : ''; ?>">
	        			<?php echo form_label('Book' . lang('bf_form_label_required'), 'issue_book_book_id', array('class' => "control-label")); ?>
	        			<?php echo form_dropdown('issue_book_book_id', $books_dropdown_values, '','','id="issue_book_book_id" class="form-control" style="width: 530px;"');?>
						<p class="help-block"><?php echo form_error('issue_book_book_id'); ?></p>
					</div>
					<div class="form-group <?php echo form_error('issue_book_book_copy_id') ? 'has-error' : ''; ?>">
						<?php echo form_label('Book\'s UID' . lang('bf_form_label_required'), 'issue_book_book_copy_id', array('class' => "control-label")); ?>
	        			<?php echo form_dropdown('issue_book_book_copy_id', array(''=>'Select UID'), '','','id="issue_book_book_copy_id" class="form-control" style="width: 530px;"');?>
						<p class="help-block"><?php echo form_error('issue_book_book_copy_id'); ?></p>
					</div>
					<div class="form-group <?php echo form_error('issue_book_student_id') ? 'has-error' : ''; ?>">
	        			<?php echo form_label('Student' . lang('bf_form_label_required'), 'issue_book_student_id', array('class' => "control-label")); ?>
	        			<?php echo form_dropdown('issue_book_student_id', $students_dropdown_values, '','','class="form-control" style="width: 530px;"');?>
						<p class="help-block"><?php echo form_error('issue_book_student_id'); ?></p>
					</div>
					<div class="form-group <?php echo form_error('issue_book_issue_date') ? 'has-error' : ''; ?>">
			            <?php echo form_label('Issue Date', 'issue_book_issue_date', array('class' => "control-label")); ?>
			            <input class="form-control datepicker" placeholder="Issue Date" id="issue_book_issue_date" type="text" name="issue_book_issue_date" maxlength="150" value="<?php echo set_value('issue_book_issue_date', isset($issue_book['issue_date']) ? $issue_book['issue_date'] : ''); ?>" style="width: 530px;"/>
						<p class="help-block"><?php echo form_error('issue_book_issue_date'); ?></p>
					</div>
					<div class="form-group <?php echo form_error('issue_book_return_date') ? 'has-error' : ''; ?>">
			            <?php echo form_label('Return Date', 'issue_book_return_date', array('class' => "control-label")); ?>
			            <input class="form-control datepicker" placeholder="Return Date" id="issue_book_return_date" type="text" name="issue_book_return_date" maxlength="150" value="<?php echo set_value('issue_book_return_date', isset($issue_book['return_date']) ? $issue_book['return_date'] : ''); ?>" style="width: 530px;"/>
						<p class="help-block"><?php echo form_error('issue_book_return_date'); ?></p>
					</div>

		            <input type="submit" name="save" class="btn btn-primary" value="Issue" />
		            or <?php echo anchor('/issue_book', lang('issue_book_cancel'), 'class="btn btn-warning"'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<?php //Assets::add_js("$('.pick_date').datetimepicker();",'inline');?>

<?php Assets::add_js("
	jQuery('#issue_book_book_id').change(function(){
		jQuery.get( '".site_url('/books/get_copies_by_book_id')."' +'/'+ jQuery(this).val(), function( data ) {
			var book_copies = JSON.parse(data);
			var book_copies_dropdown = '<option value=\"\">Select UID</option>';
			jQuery.each(book_copies, function(i, item) {
			    book_copies_dropdown = book_copies_dropdown + '<option value = \"' +item.id+ '\">' +item.book_uid+ '</option>';
			});
			jQuery('#issue_book_book_copy_id').html(book_copies_dropdown);
		});
	});
",'inline');?>