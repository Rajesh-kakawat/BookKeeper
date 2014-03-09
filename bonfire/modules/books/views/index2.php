<div class="row">
	<h1> Books <small>list</small></h1>
	<ol class="breadcrumb">
		<li  class="active">
			<i class="fa fa-dashboard"></i> Manage books
		</li>
	</ol>
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="table-responsive">
			<?php echo form_open($this->uri->uri_string()); ?>
				<table class="table table-striped table-bordered table-hover dataTable no-footer">
					<thead>
						<tr>
							<th>Edit</th>
							<th>ISBN</th>
							<th>Title</th>
							<th>Author</th>
							<th>Publisher</th>
							<th>Year</th>
							<th>Issued To</th>
						</tr>
					</thead>
					<?php if (isset($book_records) && is_array($book_records) && count($book_records)) : ?>
					<tfoot>
						<?php //if ($this->auth->has_permission('Books.Content.Delete')) : ?>
						<tr>
							<td colspan="9">
								<?php echo lang('bf_with_selected') ?>
								<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('books_delete_confirm'); ?>')">
							</td>
						</tr>
						<?php endif;?>
					</tfoot>
					<?php //endif; ?>
					<tbody>
					<?php if (isset($book_records) && is_array($book_records) && count($book_records)) : ?>
					<?php foreach ($book_records as $record) : ?>
						<tr>
							<td><?php echo anchor(site_url('/books/edit/'. $record->id), '<i class="fa fa-edit"></i>') ?></td>
							<td><?php echo $record->isbn?></td>
							<td><?php echo $record->title?></td>
							<td><?php echo $record->author?></td>
							<td><?php echo $record->publisher?></td>
							<td><?php echo date("d-m-Y", strtotime($record->year));?></td>
							<td></td>
						</tr>
					<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="9">No records found that match your selection.</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<?php
	Assets::add_js("
	jQuery('.table').dataTable();
	",'inline');
?>