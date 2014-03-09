<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Books</h1>
    </div>
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
					<div class="alert alert-danger alert-dismissable">
					  <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					  <h4 class="alert-heading">Please fix the following errors :</h4>
					 <?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>
				<?php // Change the css classes to suit your needs
					if( isset($books) ) {
					    $books = (array)$books;
					}
					$id = isset($books['id']) ? $books['id'] : '';
				?>
				<?php echo form_open($this->uri->uri_string()); ?>
	       			<div class="form-group <?php echo form_error('books_isbn') ? 'has-error' : ''; ?>">
	            		<?php echo form_label('ISBN'. lang('bf_form_label_required'), 'books_isbn', array('class' => "control-label") ); ?>
	        			<input class="form-control"  id="books_isbn" type="text" name="books_isbn" maxlength="20" value="<?php echo set_value('books_isbn', isset($books['isbn']) ? $books['isbn'] : ''); ?>"  />
	    				<p class="help-block"><?php echo form_error('books_isbn'); ?></p>
	        		</div>
			        <div class="form-group <?php echo form_error('books_title') ? 'has-error' : ''; ?>">
			            <?php echo form_label('Title', 'books_title', array('class' => "control-label") ); ?>
			            <input class="form-control"  id="books_title" type="text" name="books_title" maxlength="150" value="<?php echo set_value('books_title', isset($books['title']) ? $books['title'] : ''); ?>"  />
	    				<p class="help-block"><?php echo form_error('books_title'); ?></p>
			        </div>

			        <div class="form-group <?php echo form_error('books_author') ? 'has-error' : ''; ?>">
			            <?php echo form_label('Author', 'books_author', array('class' => "control-label") ); ?>
				        <input class="form-control"  id="books_author" type="text" name="books_author" maxlength="150" value="<?php echo set_value('books_author', isset($books['author']) ? $books['author'] : ''); ?>"  />
				        <p class="help-block"><?php echo form_error('books_author'); ?></p>
	        		</div>

	        		<div class="form-group <?php echo form_error('books_publisher') ? 'has-error' : ''; ?>">
			            <?php echo form_label('Publisher', 'books_publisher', array('class' => "control-label") ); ?>
				        <input class="form-control"  id="books_publisher" type="text" name="books_publisher" maxlength="150" value="<?php echo set_value('books_publisher', isset($books['publisher']) ? $books['publisher'] : ''); ?>"  />
				        <p class="help-block"><?php echo form_error('books_publisher'); ?></p>
	        		</div>

	        		<div class="form-group <?php echo form_error('books_year') ? 'has-error' : ''; ?>">
	            		<?php echo form_label('Year', 'books_year', array('class' => "control-label") ); ?>
				        <input class="form-control datepicker"  id="books_year" type="text" name="books_year" maxlength="50" value="<?php echo set_value('books_year', isset($books['year']) ?  date("d-m-Y", strtotime($books['year'])) : ''); ?>"  />
				        <p class="help-block"><?php echo form_error('books_year'); ?></p>
			        </div>

	            	<input type="submit" name="save" class="btn btn-primary" value="Edit books" />
		            or <?php echo anchor('/books', lang('books_cancel'), 'class="btn btn-warning"'); ?>
		            or <?php echo anchor(site_url('/books/delete/'. $id), '<i class="fa fa-trash-o">&nbsp;</i>&nbsp;'.lang('books_delete_record'),'class="btn btn-danger" title="Delete Book" onclick="return confirm(\''.lang('books_delete_confirm').'\')"') ?>
		    	<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
