<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/16/2016
 * Time: 3:47 PM
 */?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Karmanta - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Karmanta, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHIVOLCS Project Management System</title>
</head>
<body>
<section id="container" class="">

    <header class="header white-bg">
        <div class="toggle-nav">
            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
        </div>

        <!--logo start-->
        <a href="dashboard" class="logo"><img src='<?=base_url()?>/assets/images/Phivolcs_logo.svg.png' width='50' heigth='50'>PHI<span>VOLCS</span> <span class="lite">PHILIPPINES</span></a>
        <!--logo end-->

        <div class="nav search-row" id="top_menu">
            <!--  search form start -->

            <!--  search form end -->
        </div>
        <div class="top-nav notification-row">
            <!-- notificatoin dropdown start-->
            <ul class="nav pull-right top-menu">
                <!-- alert notification start-->
                <li id="alert_notificatoin_bar" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon-bell-l"></i>
                        <span class="badge bg-success" id="notif_cnt">0</span>
                    </a>
                    <ul class="dropdown-menu extended notification" id="ulnotif">
                        <!--
                        <li>
                            <p class="blue" id="notif_new">You have 4 new notifications</p>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-primary"><i class="icon_profile"></i></span>
                                Friend Request
                                <span class="small italic pull-right">5 mins</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-warning"><i class="icon_pin"></i></span>
                                John location.
                                <span class="small italic pull-right">50 mins</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-danger"><i class="icon_book_alt"></i></span>
                                Project 3 Completed.
                                <span class="small italic pull-right">1 hr</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-success"><i class="icon_like"></i></span>
                                Mick appreciated your work.
                                <span class="small italic pull-right"> Today</span>
                            </a>
                        </li-->
                    </ul>
                </li>
                <!-- alert notification end-->
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="profile-ava">
                                    <img alt="" src="<?=base_url()?>/assets/images/avatar1_small.jpg">
                                </span>
                        <span class="username"><?php echo $_SESSION['username'];?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li style="display:none">
                            <a href="#"><i class="icon_profile"></i> My Profile</a>
                        </li>
                        <li>
                            <a href="projectarchive"><i class="icon_archive_alt"></i>View Projects</a>
                        </li>
                        <?php if($_SESSION['position'] != 3 && $_SESSION['division'] != 3){
                            echo '<li>
                                    <a href="task"><i class="icon_book_alt"></i>Manage Tasks</a>
                                </li>';
                            }?>
                        <li>
                            <a href="javascript:void(0)" onclick="logout()"><i class="icon_key_alt"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
            <!-- notificatoin dropdown end-->
        </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu">
                <li id='dashboard'>
                    <a class="" href="dashboard" >
                        <i class="icon_house_alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sub-menu" id='projectsub'>
                    <a class="">
                        <i class="icon_desktop"></i>
                        <span>Project</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li id='vproject'><a class="" href="projectarchive">View Projects</a></li>
                        <?php if($_SESSION['position'] == 2){?>
                        <li id='propose'><a class=""  href="proposeproject">Propose New Project</a></li>
                        <?php }if($_SESSION['position'] == 3){?>
                        <li id='progress'><a class=""  href="progress">Make Progress Report</a></li>
                        <?php }if($_SESSION['position'] != 3 && $_SESSION['division'] != 3){?>
                        <li id='manage'><a class=""  href="task">Manage Task</a></li>
                        <?php }?>
                    </ul>
                </li>
                <?php if($_SESSION['position'] != 3){?>
                <li id='records'>
                    <a class="" href="records">
                        <i class="icon_document_alt"></i>
                        <span>Records</span>
                    </a>
                </li>
                <?php }?>
                <li id='pnature'>
                    <a class="" href="projectnature">
                        <i class="icon_genius"></i>
                        <span>Project Nature</span>
                    </a>
                </li>
                <li id='parchive'>
                    <a class="" href="completedprojects">
                        <i class="icon_archive_alt"></i>
                        <span>Projects Archive</span>
                    </a>
                </li>
                <li class="sub-menu" id='reports'>
                    <a class="">
                        <i class="icon_datareport"></i>
                        <span>Reports</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li id='rproj2'><a class="" href="equipmentstatus">Equipment Status</a></li>
                        <li id='rproj3'><a class="" href="projectload">Project Load</a></li>
                        <li id='rproj4'><a class="" href="personnel">Personnel Involved</a></li>
                        <li id='rproj6' ><a class="" href="budgetreport">Budget Report</a></li>
                        <li id='rproj7' ><a class="" href="accomplishreport">Accomplishment Report</a></li>
                    </ul>
                </li>
                <li id='profile'>
                    <a class="" href="widgets.html" style="display:none">
                        <i class="icon_genius"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
</section>
<script>

    function logout() {
        window.location.replace('logout');
    }
    $("#projectsub,#reports").click(function(){
        $('.sub',this).toggle();
        var flag = $('.sub',this).css('display');
        if(flag == 'none')
            $('.arrow_carrot-down',this).addClass('arrow_carrot-right').removeClass('arrow_carrot-down');
        else
            $('.arrow_carrot-right',this).addClass('arrow_carrot-down').removeClass('arrow_carrot-right');
    });

    function markallread() {
        //$("#alert_notificatoin_bar").removeClass('dropdown'); 
        $("#notif_cnt").removeClass('bg-important');
        $("#notif_cnt").addClass('bg-success');
        $("#notif_cnt").html(0);

        $("#ulnotif > li").css("background-color", "#ffffff");
        $("#countstr").html("You have 0 new notifications.");
        //$("#alert_notificatoin_bar").addClass('dropdown open');
        $.get("<?=base_url()?>notification/markallread_notification_control");
        
        if (document.location.href == '<?=base_url()?>notification') {
            $("#ntable > tbody > tr > td").css("background-color", "#ffffff");
        }
    }

    function markread(id_val,redirect_val) {
        $.post("<?=base_url()?>notification/markread_notification_control",{ id: id_val},
            function(data) { 
                window.location = "<?=base_url()?>" + redirect_val;
            });
    }

    $(function() {
        $.get("<?=base_url()?>notification/get_notifications_unread_count_control",{},
            function(data) {
                if (data > 0) {
                    $("#notif_cnt").removeClass('bg-success');
                    $("#notif_cnt").addClass('bg-important');
                }
                else {
                    $("#notif_cnt").removeClass('bg-important');
                    $("#notif_cnt").addClass('bg-success');                
                }
                $("#notif_cnt").html(data);
        });

        $.get("<?=base_url()?>notification/get_notifications_header_control",{},
            function(data) {
                $("#ulnotif").html(data);
        });
    });

</script>
</body>
</html>

