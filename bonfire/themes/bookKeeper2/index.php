<?php
	Assets::add_js(
		array(
			'jquery-1.10.2.js',
			'bootstrap.min.js',
			'bootstrap-datepicker.js',
			'plugins/dataTables/jquery.dataTables.js',
			'plugins/dataTables/dataTables.bootstrap.js',
			'plugins/morris/raphael-2.1.0.min.js',
			'plugins/morris/morris.js',
			'script.js',
		)
	);

	Assets::add_css(
		array(
			'bootstrap.min.css',
			'font-awesome/css/font-awesome.css',
		 	'plugins/morris/morris-0.4.3.min.css',
		 	'plugins/timeline/timeline.css',
		 	'plugins/dataTables/dataTables.bootstrap.css',
		 	'sb-admin.css',
			'datepicker.css'
			)
		);
?>
<!DOCTYPE html>
<html>
	<head>

	    <meta charset="utf-8">
	    <title>Start Bootstrap - SB Admin Version 2.0 Demo</title>

		<?php echo Assets::css(); ?>
	</head>
	<body>
	    <div id="wrapper">
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		    	<div class="navbar-header">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="index.html">BookKeeper v2.0</a>
	            </div>
            	<!-- /.navbar-header -->
	             <ul class="nav navbar-top-links navbar-right">
	                <li class="dropdown">
	                </li>
	             </ul>
	        </nav>
        	<!-- /.navbar-static-top -->

	        <nav class="navbar-default navbar-static-side" role="navigation">
	        	<div class="sidebar-collapse">
	                <ul class="nav" id="side-menu">
	                    <li class="sidebar-search">
	                        <div class="input-group custom-search-form">
	                            <input type="text" class="form-control" placeholder="Search...">
	                            <span class="input-group-btn">
	                                <button class="btn btn-default" type="button">
	                                    <i class="fa fa-search"></i>
	                                </button>
	                            </span>
	                        </div>
	                        <!-- /input-group -->
	                    </li>
	                    <li>
	                        <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
	                    </li>
	                    <li>
	                        <a href="<?php echo site_url('student')?>"><i class="fa fa-user fa-fw"></i> Manage Student</a>
	                    </li>
	                    <li>
	                        <a href="<?php echo site_url('books')?>"><i class="fa fa-user fa-fw"></i> Manage Books</a>
	                    </li>
	                    <li>
	                        <a href="<?php echo site_url('issue_book')?>"><i class="fa fa-user fa-fw"></i> Issue Books</a>
	                    </li>
	                    <li>
	                        <a href="index.html"><i class="fa fa-dashboard fa-fw"></i>Take Books</a>
	                    </li>
	               </ul>
				</div>
			</nav>
			<div id="page-wrapper">
				<?php
					echo isset($content) ? $content : Template::yield();
				?>
			</div>
			<?php echo Assets::js(); ?>
	    </div>
	</body>
</html>