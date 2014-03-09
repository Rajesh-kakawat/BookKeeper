<div class="row">
	<h1> Issued Books</h1>
	<ol class="breadcrumb">
		<li  class="active">
			<i class="fa fa-dashboard"></i> Manage Issued Books
		</li>
	</ol>
</div>

<ul class="nav nav-tabs" >
	<li <?php echo $filter_type=='issued' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('/issue_book/index').'/' .'issued/'; ?>">Issued</a></li>
	<li <?php echo $filter_type=='submitted' ? 'class="active"' : ''; ?>><a href="<?php echo site_url('/issue_book/index/submitted'); ?>">Submitted</a></li>
	<li class="<?php echo $filter_type=='student' ? 'active ' : ''; ?>dropdown">
		<a href="#" class="drodown-toggle" data-toggle="dropdown">
			Student <?php echo isset($filter_student) ? ": $filter_student" : ''; ?>
			<b class="caret light-caret"></b>
		</a>
		<ul class="dropdown-menu" id="ul_student_filter">
		
			<li>
				<input class="form-control" placeholder="Student Name" id="txt_filter_student" type="text" maxlength="20" />
			</li>
			<li>
				<button id="searchStudent">Search</button>
			</li>
		</ul>
	</li>
</ul>
<div class="row">
	<div class="table-responsive" style="width: 1080px;">
		<table class="table table-striped dataTablestable table-bordered table-hover dataTables no-footer">
			<thead>
				<tr>
					<th>UID</th>
					<th>Book</th>
					<th>Student</th>
					<th>Issue Date</th>
					<th>Return Date</th>
					<th>Return On</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tbody>
			<?php foreach ($records as $record) : ?>
				<?php 
				$style = ' class="success"';
				if($record->submit_date == null)
				{
					$style = ' class="danger"';
					if(strtotime($record->return_date) > time())
						$style = ' class="warning"';
				}

				?>
				<tr<?php echo $style;?>>
					<td><?php echo $book_uid[$record->book_copy_id]?></td>
					<td><?php echo $book_title[$record->book_id]?></td>
					 
					<td><a href="<?php echo site_url('/student/student_detail/'.$record->student_id)?>"><?php echo $student_name[$record->student_id]?></a></td>
					<td><?php echo date("d-m-Y", strtotime($record->issue_date))?></td>
					<td><?php echo date("d-m-Y", strtotime($record->return_date))?></td>
					<!-- <td><?php //echo $record->submit_date?date("d-m-Y", strtotime($record->submit_date)):""?></td> -->
					
					<?php 
					if($record->submit_date == null)
					{
						echo "<td></td>";
						echo "<td>".anchor(site_url('/issue_book/edit/'. $record->id), '<i class="icon-pencil">&nbsp;</i>'.'edit')."</td>";
						echo "<td>".anchor(site_url('/issue_book/submitbook/'. $record->id), '<i class="icon-pencil">&nbsp;</i>'.'submit')."</td>";
					}
					else 
					{
						echo "<td>".date("d-m-Y", strtotime($record->submit_date))."</td>";
						echo "
							<td></td>
							<td></td>
							";
					}
					?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
			<?php else: ?>
				<span>No records found that match your selection.</span>
			<?php endif; ?>
	</div>
</div>

<?php 
	Assets::add_js("
		
	jQuery('#searchStudent').click(function(){
		var name = jQuery('#txt_filter_student').val();
		if(name!='')
			window.location = '". site_url('/issue_book/index').'/'. 'student-'."' + name; 
	});

	jQuery('#ul_student_filter').focusin(function() {
		jQuery(this).css('display', 'list-item');
	});
	
	jQuery('#ul_student_filter').focusout(function() {
		jQuery(this).css('display', '');
	});
	",'inline');
?>