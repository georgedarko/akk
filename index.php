<?php
session_start();
include 'functions/housekeeping.php';
//check if the user logged in has permissions to this page
$is_valid = validate_user(array(1, 2));
if ($is_valid == 165) {
    $page_title = "Login";
}
if ($is_valid == 166) {
    $page_title = "Not Authorized";
}
if ($is_valid == 167) {
    $page_title = $pt[$_REQUEST['p']];
}

function yes_no($val) {
    if ($val == 1)
        return "YES";
    if (strtoupper($val) == "YES")
        return 1;
    if ($val == -1)
        return "NO";
    if (strtoupper($val) == "YES")
        return -1;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>AKK Audit Report</title>
        <!-- style references -->
        <meta charset="UTF-8">
        <meta name="description" content="AKK Audit Reporting Application">
        <meta name="keywords" content="Cell Reporting, Audit Report, AKK">
        <meta name="author" content="Sci-fi Web Technologies">

        <!-- style references -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/pagination.css" rel="stylesheet">
        <script language="JavaScript" src="FusionCharts/JSClass/FusionCharts.js"></script>
        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                <script src="assets/js/html5shiv.js"></script>
        <![endif]-->
    </head>

    <body>
        <!-- Top Navigation -->
        <div class="navbar navbar-inverse navbar-static-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="#"> AKK Audit Report</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">

                            <li><a href="actions/logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Top Navigation -->

        <!-- hero-unit -->
        <div class="hero-unit drop-shadow raised">
            <h4><i class="icon-signal"></i> <?php echo $page_title ?></h4>
        </div>
        <!-- End hero-unit -->

        <div class="container">
            <!-- subnav -->
            <!-- horizontal nav-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <ul class="nav nav-pills">
                            <?php
                            if ($_REQUEST['p'] == "query_issues") {
                                echo "<li class='active'>";
                                echo "<a href='?p=query_issues&loc=forms'>Query Issues</a>";
                                echo "</li>";
                            }
                            else{
                            echo "<li>";
                                echo "<a href='?p=query_issues&loc=forms'>Query Issues</a>";
                                echo "</li>";
                            }
                            if($_REQUEST['p'] == "query_icnirp"){
                                echo "<li class='active'>";
                                echo "<a href='?p=query_icnirp&loc=forms'>Query Icnirp Values</a>";
                                echo "</li>";
                            }
                            else{
                                echo "<li>";
                                echo "<a href='?p=query_icnirp&loc=forms'>Query Icnirp Values</a>";
                                echo "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end of subnav -->

            <div class="row-fluid">
                <!-- body -->
                <?php
                //include form or page here
                if ($is_valid == 165) {
                    include_once("forms/login.php");
                } else {
                    if ($_REQUEST['loc'] == "" || $_REQUEST['p'] == "") {
                        include_once("forms/query_icnirp.php");
                    } else {
                        include_once($_REQUEST['loc'] . "/" . $_REQUEST['p'] . ".php");
                    }
                }
                ?>
            </div>
        </div>

        <!-- footer -->
        <div id="footer">
            <div class="container clearfix">
                <hr class="footer-divider">
                <span class="pull-left">&copy; 2013 AKK Risk Management. All rights reserved</span>
                <span class="pull-right">
                    Powered by <a href="http://www.sci-fiwebtech.com">Sci-Fi Web Technologies</a>
                </span>
            </div>
        </div>
        <!-- /.#footer -->

    </body>
</html>