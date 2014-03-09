<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Student Detail</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i>
				<?php echo $student->name?>
			</div>
			<div class="panel-body">
				<table class="table">
					<tr>
						<th>Name</th><td><?php echo $student->name?></td>
					</tr>
					<tr>
						<th>Address</th><td><?php echo $student->address?></td>
					</tr>
					<tr>
						<th>Course</th><td><?php echo $student->course?></td>
					</tr>
					<tr>
						<th>Batch</th><td><?php echo $student->batch?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i>
				Book issued
			</div>
			<div class="panel-body">
				<table class="table table-striped dataTablestable table-bordered table-hover dataTables">
					<thead>
						<tr>
							<th>ISBN</th>
							<th>Title</th>
							<th>Author</th>
							<th>Issue Date</th>
							<th>Return Date</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
					<?php if (isset($books_issued) && is_array($books_issued) && count($books_issued)) : ?>
					<?php foreach ($books_issued as $book) : ?>
						<?php
							$style = ' style="color: red;"';
							if(strtotime($book->return_date) > time())
								$style = ' style="color: orange;"';
							else
								$style = ' style="color: red;"';
						?>
						<tr<?php echo $style;?>>
							<td><?php echo $book->isbn ?></td>
							<td><?php echo $book->title ?></td>
							<td><?php echo $book->author?></td>
							<td><?php echo $book->issue_date?></td>
							<td><?php echo $book->return_date?></td>
							<td>
								<?php echo anchor(site_url('/student/submit_book/'.$student->id.'/'.$book->issue_id), '<i class="icon-pencil">&nbsp;</i>'.'submit');?>
							</td>
						</tr>
					<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="9">No books are issued. <a href="#">Issue book ?</a></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
