<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Book Detail</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i>
				<?php echo $book_details->title?>
				<div class="pull-right">
					<a class="pull-right btn btn-outline btn-primary btn-xs" href="<?php echo site_url('books/add_book_quantity/');?>"><i class="fa fa-user fa-fw"></i> Add Quantity</a>
				</div>
			</div>
			<div class="panel-body">
				<table class="table">
					<tr>
						<th>Title</th><td><?php echo $book_details->title?></td>
					</tr>
					<tr>
						<th>Author</th><td><?php echo $book_details->author?></td>
					</tr>
					<tr>
						<th>Publisher</th><td><?php echo $book_details->publisher?></td>
					</tr>
					<tr>
						<th>Year</th><td><?php echo date("d-m-Y", strtotime($book_details->year))?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i>
				Book Copies Available
			</div>
			<div class="panel-body">
				<table class="table table-striped dataTablestable table-bordered table-hover dataTables no-footer">
				<thead>
					<tr>
						<th>Book U.ID</th>
						<th>Issued To</th>
						<th>Return Date</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
				<?php if (isset($books_in_category_arr) && is_array($books_in_category_arr) && count($books_in_category_arr)) : ?>
				<?php foreach ($books_in_category_arr as $id=>$book) : ?>
					<?php
						$style = ' class="success"';
						if(array_key_exists($id,$books_in_category_issued_arr) && $books_in_category_issued_arr[$id]->submit_date == NULL)
						{
							$style = ' class="danger"';
							if(strtotime($books_in_category_issued_arr[$id]->return_date) > time())
								$style = ' class="warning"';
						}

					?>
					<tr<?php echo $style;?>>
						<td><?php echo $book->book_uid ?></td>
						<?php if(array_key_exists($id,$books_in_category_issued_arr) && $books_in_category_issued_arr[$id]->submit_date==NULL)
						{
							echo "<td>".anchor(site_url('/student/student_detail/'.$books_in_category_issued_arr[$id]->student_id), $books_in_category_issued_arr[$id]->student_name)."</td>";
							echo "<td>".date("d-m-Y", strtotime($books_in_category_issued_arr[$id]->return_date))."</td>";
							echo "<td>".anchor(site_url('/books/submit_book/'.$book_id.'/'.$books_in_category_issued_arr[$id]->id), '<i class="icon-pencil">&nbsp;</i>'.'sumbit')."</td>";
							echo "<td></td>";
						}
						else
						{
							echo "<td> - </td>";
							echo "<td> - </td>";
							echo "<td>".anchor(site_url('/issue_book/issue_book_by_book_detail/'.$book_id.'/'.$book->id), '<i class="icon-pencil">&nbsp;</i>'.'issue')."</td>";
							echo "<td>".anchor(site_url('/books/delete_book_copy/'.$book_id.'/'.$book->id), '<i class="fa fa-trash-o">&nbsp;</i>','title="Delete Book" onclick="return confirm(\''.lang('books_delete_confirm').'\')"')."</td>";
						}
						?>

					</tr>
				<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="9">No Books</td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>


