<!DOCTYPE html>
<html ng-app="hrmPayroll">
<head>
    <meta charset="utf-8">
    <title>HRMS</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href="/favicon.ico">
    <!-- Font Awesome -->
    <link href="/app/css/vendors.css" rel="stylesheet">
    <base href="/">
    <script type="text/javascript">
        var baseURL = "<?php echo URL::to('/'); ?>/";
        var appURL = "<?php echo env('APP_PATH'); ?>/";
    </script>
    <base href="/">
</head>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper" ng-controller="mainController">

<div ng-if="loggedIn">@include('side-menu')</div>

        <ng-view></ng-view>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.6
        </div>
        <strong>Copyright &copy; 2016 <a href="#">HRMS</a>.</strong> All rights
        reserved.
    </footer>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.2/ui-bootstrap-tpls.min.js"></script>
<script src="app/js/vendors.js"></script>
<script src="app/js/app.js"></script>

</body>

</html>
