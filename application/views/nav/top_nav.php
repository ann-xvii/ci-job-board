

<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-job-board">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo base_url(); ?>" class="navbar-brand">Job Board</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse-job-board">
			<ul class="nav navbar-nav">
				<li class="active"><?php echo anchor('jobs/create', 'Create'); ?></li>
			</ul>
		</div> <!-- navbar-collapse -->
	</div>
</nav>

<div class="container theme-showcase" role="main">