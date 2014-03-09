<div style="display: none;">
	<div id="book_uid_field">
		<div style="padding-bottom: 7px;">
			<input class="form-control" placeholder="Book UID" id="book_copies_book_uid" type="text" name="book_copies_book_uid[]" maxlength="150" value="" style="width: 530px;"/>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<h1> Add Book </h1>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('/books')?>"> <i class="fa fa-dashboard"></i> Manage Books</a>
			</li>
			<li class="active">
				<i class="fa fa-user"></i>
				Add Book
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php if (validation_errors()) : ?>
			<div class="alert alert-dismissable alert-danger">
		  		<a class="close" data-dismiss="alert">&times;</a>
		  		<h4 class="alert-heading">Please fix the following errors :</h4>
		 		<?php echo validation_errors(); ?>
			</div>
		<?php endif; ?>
		
		<?php echo form_open($this -> uri -> uri_string(), 'class="form-horizontal"'); ?>
			<fieldset>
			
        		<?php echo form_label('Book' . lang('bf_form_label_required'), 'book_copies_book_id', array('class' => "control-label")); ?>
        		<?php echo form_dropdown('book_copies_book_id', $books_dropdown_values, $book_id,'','id="book_copies_book_id" class="form-control" style="width: 530px;"');?>
				<span class="help-inline"><?php echo form_error('book_copies_book_id'); ?></span>
				
				<?php echo form_label('Number of books' . lang('bf_form_label_required'), 'book_copies_num_of_books', array('class' => "control-label")); ?>
	            <input class="form-control" placeholder="Enter number of books" name="book_copies_num_of_books" id="book_copies_num_of_books" type="text" maxlength="150" value="<?php echo set_value('book_copies_num_of_books', isset($_POST['book_copies_num_of_books']) ? $_POST['book_copies_num_of_books'] : ''); ?>" style="width: 530px;"/>
				<span class="help-inline"><?php echo form_error('book_copies_num_of_books'); ?></span>
				
				<div id="book_uid"></div>

		        <div class="form-actions">
		            <br/>
		            <input type="submit" name="add" class="btn btn-primary" value="Add" />
		            or <?php echo anchor('/books', lang('books_cancel'), 'class="btn btn-warning"'); ?>
		        </div>
		<?php echo form_close(); ?>
	</div>
</div>

<?php //Assets::add_js("$('.pick_date').datetimepicker();",'inline');?>

<?php Assets::add_js("

	jQuery('#book_copies_num_of_books').keyup(function(){
		var num = jQuery(this).val();
		var uid_fields = '';
		
		jQuery('#book_uid').empty();
		
		if(/^[0-9]+$/.test(num))
		{
			jQuery('#book_uid').html(\"<label class='control-label'>Book UID<span class='required'>*</span></label>\");	
			
			for (var i=0;i<num;i++)
			{ 
				jQuery('#book_uid_field div').clone().appendTo('#book_uid');
				//console.log(jQuery('#book_uid').html());
			}
		}
		else if(num!='')
		{
			alert('Enter valid number');
			jQuery(this).val('');
		}
	});

	/*jQuery('#issue_book_book_id').change(function(){
		jQuery.get( '".site_url('/books/get_copies_by_book_id')."' +'/'+ jQuery(this).val(), function( data ) {
			var book_copies = JSON.parse(data);
			var book_copies_dropdown = '<option value=\"\">Select UID</option>';
			jQuery.each(book_copies, function(i, item) {
			    book_copies_dropdown = book_copies_dropdown + '<option value = \"' +item.id+ '\">' +item.book_uid+ '</option>';
			});
			jQuery('#issue_book_book_copies_id').html(book_copies_dropdown);
		});
	});*/
",'inline');

if (isset($_POST['book_copies_num_of_books']))
{
	Assets::add_js("
		jQuery('#book_copies_num_of_books').trigger('keyup');
	",'inline');
}
	?>