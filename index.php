<?php

	$username = 'omar.yerden';

	$profileAvatar = 'default_avatar-xs.jpg';
	$profileLabel = 'Omar Yerden';
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>Dashboard - CoCa Admin</title>

	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">

	 <!-- Plugin CSS -->
	<link rel="stylesheet" href="js/plugins/morris/morris.css">
	<link rel="stylesheet" href="js/plugins/icheck/skins/minimal/blue.css">
	<link rel="stylesheet" href="js/plugins/select2/select2.css">
	<link rel="stylesheet" href="js/plugins/fullcalendar/fullcalendar.css">

	<!-- App CSS -->
	<link rel="stylesheet" href="css/target-admin.css">
	<link rel="stylesheet" href="css/custom.css">

	<link rel="stylesheet" href="css/demos/ui-notifications.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<div class="navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-cogs"></i></button>
				<a class="navbar-brand navbar-brand-image" href="index.php"><img src="img/logo-coca.png" alt="CoCa Admin"></a>
			</div> <!-- /.navbar-header -->

			<div class="navbar-collapse collapse">
				<!-- Menu de notificaciones /* A la izquierda al lado del logo */ -->
				<ul class="nav navbar-nav noticebar navbar-left">
				<!-- Pendiente /* Notificaciones */ -->
				</ul>

				<!-- Menu de usuario /* A la derecha */ -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown navbar-profile">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
            				<img src="img/avatars/<?php echo $profileAvatar; ?>" class="navbar-profile-avatar" alt="">
            				<span class="navbar-profile-label"><?php echo $profileLabel ?> &nbsp;</span>
            				<i class="fa fa-caret-down"></i>
          				</a>
						<ul class="dropdown-menu" role="menu">
			            	<li><a href="page-profile.html"><i class="fa fa-user"></i>&nbsp;&nbsp;My Profile</a></li>
			            	<li class="divider"></li>
							<li><a href="account-login.html"><i class="fa fa-sign-out"></i> &nbsp;&nbsp;Logout </a></li>
						</ul>

					</li>
				</ul>
			</div>
		</div> <!-- end container -->
	</div> <!-- End navbar -->

	<div class="mainbar">
		<div class="container">
			<button type="button" class="btn mainbar-toggle" data-toggle="collapse" data-target=".mainbar-collapse">
				<i class="fa fa-bars"></i>
			</button>

			<div class="mainbar-collapse collapse">
				<ul class="nav navbar-nav mainbar-nav">
					<li class="active"><a href="index.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
					<li class=""><a href="new_request.php"><i class="fa fa-plus"></i>Request Change</a></li>
                    <li class=""><a href="request-information.php"><i class="fa fa-info"></i>Request Information</a></li>
					<li class=""><a href="task_calendar.php"><i class="fa fa-calendar"></i>Task Calendar</a></li>
				</ul>
			</div>
		</div>
	</div> <!-- End mainbar -->

	<div class="container">
		<div class="content">
			<div class="content-container">
				<!-- Each div is a module -->
				<div>
					<h4 class="heading-inline">Change requests&nbsp;&nbsp;
        				<small>Updated last time today at</small>&nbsp;&nbsp;
        			</h4>

        			<div class="btn-group ">
						<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
							<i class="fa fa-refresh"></i>&nbsp; Update Now
						</button>
        			</div>
				</div>

				<br />

				<!-- Recap -->
				<div class="row">
					<!-- QuickData - Pending -->
					<div class="col-sm-6 col-md-3">
          				<div class="row-stat pending-to-approvals">
            				<p class="row-stat-label">Pending to aprovals</p>
            				<h3 class="row-stat-value">0</h3>
            				<!-- <span class="label label-success row-stat-badge">+9%</span> -->
          				</div> <!-- /.row-stat -->
        			</div> <!-- /.col -->

					<!-- QuickData - Changes in progress -->
					<div class="col-sm-6 col-md-3">
          				<div class="row-stat approved">
            				<p class="row-stat-label">Approved</p>
            				<h3 class="row-stat-value">0</h3>
            				<!-- <span class="label label-success row-stat-badge">+43%</span> -->
          				</div> <!-- /.row-stat -->
        			</div> <!-- /.col -->

					<!-- QuickData - Changes in progress -->
					<div class="col-sm-6 col-md-3">
          				<div class="row-stat changes-in-process">
            				<p class="row-stat-label">Changes in process</p>
            				<h3 class="row-stat-value">0</h3>
            				<!-- <span class="label label-success row-stat-badge">+43%</span> -->
          				</div> <!-- /.row-stat -->
        			</div> <!-- /.col -->

					<!-- QuickData - Changes in progress -->
					<div class="col-sm-6 col-md-3">
          				<div class="row-stat closed-request">
            				<p class="row-stat-label">Closed requests</p>
            				<h3 class="row-stat-value">0</h3>
            				<!-- <span class="label label-success row-stat-badge">+43%</span> -->
          				</div> <!-- /.row-stat -->
        			</div> <!-- /.col -->
				</div>
				<!-- End row Recap -->

				<!-- Request new change -->
				<div class="row">
					<div class="col-sm-6">
						<div class="portlet">
							<!-- Header -->
							<div class="portlet-header">
								<h3><i class="fa fa-tasks"></i>Request new change by <?php echo $username; ?></h3>
							</div>
							<!-- params[createBy]=omar.yerden&params[requestBy]=marcelo.blanco&params[requestTitle]=RequestTest&params[requestDescription]=TestTestTest&params[users][]=omaryer&params[users][]=ignacio.mondino&params[servers][]=legabox8&params[servers][]=legabox9 -->
							<div class="portlet-content">
								<form id="new-change-request" action="" data-validate="parsley" class="form parsley-form">
								<!-- <form id="validate-basic" action="http://preview.jumpstartthemes.com/target-admin/form-validation.html" data-validate="parsley" class="form parsley-form"> -->

									<input type="hidden" name="createBy" value="<?php echo $username; ?>" class="formData" />

									<div class="form-group">
					                	<label for="requestBy">Request By</label>
					                	<input type="text" id="requestBy" name="requestBy" class="formData form-control" data-required="true" placeholder="Requested by..." tabindex="1" >
					                </div>

									<div class="form-group">
					                	<label for="users">Executed by (can be more than one)</label>
						                <select data-required="true" multiple="multiple" id="users" name="users" class="formData form-control" tabindex="2">
						                	<option>omar.yerden</option>
						                	<option>ignacio.mondino</option>
						                </select>
					                </div>

									<div class="form-group">
					                	<label for="servers">Servers to (can be more than one)</label>
						                <select data-required="true" multiple="multiple" id="servers" name="servers" class="formData form-control" tabindex="3">
						                	<optgroup label="IMAN">
						                		<option>LegaBox 1</option>
						                		<option>LegaBox 2</option>
						                		<option>LegaBox 3</option>
						                	</optgroup>
						                	<optgroup label="SMURF">
						                		<option>db1</option>
						                	</optgroup>
						                </select>
					                </div>

									<div class="form-group">
					                	<label for="requestTitle">Request Title</label>
					                	<input type="text" id="requestTitle" name="requestTitle" class="formData form-control" data-required="true" placeholder="Input a title for this request..." tabindex="4" >
					                </div>

									<div class="form-group">
                  						<label for="requestDescription">Request Description</label>
                  						<textarea data-required="true" data-minlength="5" name="requestDescription" id="requestDescription" cols="10" rows="4" class="formData form-control" placeholder="Input a description for this request..." tabindex="5"></textarea>
                					</div>

									<div class="form-group">
										<button type="submit" class="btn btn-primary" tabindex="6">Submit Request</button>
									</div>

								</form>
							</div>
							<!-- End portlet content  -->
						</div>
						<!-- End portlet [Change Request] -->
					</div>
					<!-- End col -->

					<div class="col-sm-6">
						<h4 class="heading"> Lasted Change Request </h4>
						<!-- data-provide="datatable" -->
						<table id="quick-changes-list" class="table table-bordered">
            				<thead>
              					<tr>
                					<th>#</th>
                					<th>Description</th>
									<!-- <th>Create By</th> -->
                					<th>Request By</th>
                					<th>Status</th>
                					<th></th>
					            </tr>
            				</thead>
            			</table>
					</div>

				</div>
				<!-- End Row new request -->

			</div>
			<!-- End content-container -->
		</div>
		<!-- End content -->
	</div>
	<!-- End container -->
</body>
<!-- End body -->

<script src="js/libs/jquery-1.10.1.min.js"></script>
<script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/libs/bootstrap.min.js"></script>
<script src="js/plugins/select2/select2.js"></script>
<script src="js/plugins/parsley/parsley.js"></script>
<script src="js/plugins/icheck/jquery.icheck.js"></script>

<!--[if lt IE 9]>
<script src="./js/libs/excanvas.compiled.js"></script>
<![endif]-->

<!-- App JS -->
<script src="js/target-admin.js"></script>

<script src="functions/functions.js"></script>

<!-- Plugin JS -->
<script src="js/demos/form-validation.js"></script>
<script src="js/plugins/magnific/jquery.magnific-popup.min.js"></script>
<script src="js/plugins/howl/howl.js"></script>
<script src="js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./js/plugins/datatables/DT_bootstrap.js"></script>

<script>
	$(document).ready(function(){
		$('#users').select2({placeholder: "Choose one or more user..."});
		$('#servers').select2({placeholder: "Choose one or more server..."});

        $("#new-change-request").on('submit', function(e){
            e.preventDefault();
            var form = $(this);

            // Getting data
            data = {};
            data['service'] = 'requestNewChange';
            data['params'] = getParamsForm(form);

            form.parsley().validate();

            if (form.parsley().isValid()){
                $.ajax({
                	'url': 'init.php',
                	'data': data,
                	'method': 'POST',
                	'dataType': 'json'
                }).done(function(data){
                	if(data['status'] == 'ok'){
                		//
						$.howl({ type: 'success', title: 'Change request ID #' + data['change_id'], content: data['message'], lifetime: 7500 });

						// Sending email to approvers
						$.howl({ type: 'info', title: 'Change request ID #' + data['change_id'], content: 'Sending mail to approvers', lifetime: 7500 });
						sendEmailToApprovers(data, function(){
							if(dataReturn['status'] == 'ok'){
					    		$.howl({ type: 'success', title: 'Change request ID #' + dataReturn['change_id'], content: dataReturn['message'], lifetime: 7500 });
					    	}
						});

		                // Sending email to executors
		                $.howl({ type: 'info', title: 'Change request ID #' + data['change_id'], content: 'Sending mail to executors', lifetime: 7500 });
		                sendEmailToExecutors(data, function(){
							if(dataReturn['status'] == 'ok'){
    				    		$.howl({ type: 'success', title: 'Change request ID #' + dataReturn['change_id'], content: dataReturn['message'], lifetime: 7500 });
    						}
		                });
					}
                });
            }
        });

		// Filling quick changes list
        var oTable = $('#quick-changes-list').DataTable({
			ajax: 'init.php?service=getChangesForMe&params[userId]=omar.yerden&params[orderBy]=last&params[limit]=10',
			dom: '',
			ordering: false,
			columns: [
	            {data: 'change_id'},
	            {data: 'change_title', render: function(data, type, full, meta){ return truncateText(data, 32, 'aWithTitle'); }},
	            // {data: 'created_by'},
	            {data: 'request_by'},
	            {data: 'change_status'},
	            {defaultContent: '<button type="button" onclick="loadChangeRequest(this)" class=""><i class="fa fa-info"></i></button>', 'sWidth': '30px'}
        	]
		});

		setInterval( function () {
		    oTable.ajax.reload();
		}, 9000 );

        // Getting stats from db
        getStats();
        timerStats = setInterval(function(){ getStats(); }, 3000);
	});
</script>