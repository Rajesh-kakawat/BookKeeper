<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Student List</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i>
				Manage student
				<div class="pull-right">
					<a class="pull-right btn btn-outline btn-primary btn-xs" href="<?php echo site_url('student/create');?>"><i class="fa fa-user fa-fw"></i> Add new Student</a>
				</div>
			</div>
			<div class="panel-body">
				<table id="data_table" class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Course</th>
							<th>Batch</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($students) : ?>
						<?php foreach ($students as $i=>$student) : ?>
							<tr>
								<td><?php echo $i + 1?></td>
								<td><a href="<?php echo site_url('/student/student_detail/'. $student->id)?>"><?php echo $student->name?></a></td>
								<td><?php echo $student->course?></td>
								<td><?php echo $student->batch?></td>
								<td>
									<?php echo anchor(site_url('/student/edit/'. $student->id), '<i class="fa fa-pencil-square-o">&nbsp;</i>','class="btn btn-primary btn-circle" title="Edit"') ?>
									<?php echo anchor(site_url('/student/delete/'. $student->id), '<i class="fa fa-trash-o">&nbsp;</i>','title="Delete" class="btn btn-danger btn-circle" onclick="return confirm(\''.lang('student_delete_confirm').'\')"') ?>
								</td>
							</tr>
						<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="9">No records found that match your selection.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
