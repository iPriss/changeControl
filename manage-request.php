<?php

    $username = 'omar.yerden';

    $profileAvatar = 'default_avatar-xs.jpg';
    $profileLabel = 'Omar Yerden';

    if(isset($_REQUEST['h']) && $_REQUEST['h'] != ''){

    }

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
                    <li class=""><a href="index.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
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
                <div class="content-header">
                    <h2 class="content-header-title">Manage Request</h2>
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="request-information.php">Request Information</a></li>
                        <li class="active">Manage Requests</li>
                    </ol>
                </div> <!-- /.content-header -->

                <h5 class="heading">Change Request # <?php echo isset($changeRequest) ? $changeRequest : '12345'; ?></h5>

                <ul class="icons-list notifications-list">
                    <li>
                        <i class="icon-li fa fa-ban text-danger"></i>
                        <a href="javascript:;">You </a> rejected an <a href="request-information.php?requestId=<?php echo isset($requestId) ? $requestId : '123'; ?>">Change Request</a> from <?php echo isset($requestBy) ? $requestBy : 'Omar Yerden'; ?>
                    </li>

                    <!-- <li>
                        <i class="icon-li fa fa-check-circle text-success"></i>
                        <a href="#">You</a> accepted an <a href="request-information.php?requestId=<?php echo isset($requestId) ? $requestId : '123'; ?>">Change Request</a> from <?php echo isset($requestBy) ? $requestBy : 'Omar Yerden'; ?>
                    </li> -->
                </ul>

                <br />

                <h5 class="heading">Leave a comment</h5>

                <form id="validate-enhanced">
                    <div class="form-group">
                        <textarea name="textarea-input" id="textarea-input" cols="10" rows="10" class="form-control" placeholder="Type a comment for this acction"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

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
    });
</script>