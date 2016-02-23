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
                <!-- task notificatoin start -->
                <li id="task_notificatoin_bar" class="dropdown" style="display:none">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="icon-task-l"></i>
                                    <span class="badge bg-important">5</span>
                    </a>
                    <ul class="dropdown-menu extended tasks-bar">
                        <div class="notify-arrow notify-arrow-blue"></div>
                        <li>
                            <p class="blue">You have 5 pending tasks</p>
                        </li>
                        <li>
                            <a href="#">
                                <div class="task-info">
                                    <div class="desc">Design PSD </div>
                                    <div class="percent">90%</div>
                                </div>
                                <div class="progress progress-striped">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                        <span class="sr-only">90% Complete (success)</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="task-info">
                                    <div class="desc">
                                        Project 1
                                    </div>
                                    <div class="percent">30%</div>
                                </div>
                                <div class="progress progress-striped">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                        <span class="sr-only">30% Complete (warning)</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="task-info">
                                    <div class="desc">Digital Marketing</div>
                                    <div class="percent">80%</div>
                                </div>
                                <div class="progress progress-striped">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="task-info">
                                    <div class="desc">Logo Designing</div>
                                    <div class="percent">78%</div>
                                </div>
                                <div class="progress progress-striped">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%">
                                        <span class="sr-only">78% Complete (danger)</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="task-info">
                                    <div class="desc">Mobile App</div>
                                    <div class="percent">50%</div>
                                </div>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar"  role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                        <span class="sr-only">50% Complete</span>
                                    </div>
                                </div>

                            </a>
                        </li>
                        <li class="external">
                            <a href="#">See All Tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- task notificatoin end -->
                <!-- inbox notificatoin start-->
                <li id="mail_notificatoin_bar" class="dropdown" style="display:none">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon-envelope-l"></i>
                        <span class="badge bg-important">5</span>
                    </a>
                    <ul class="dropdown-menu extended inbox">
                        <div class="notify-arrow notify-arrow-blue"></div>
                        <li>
                            <p class="blue">You have 5 new messages</p>
                        </li>
                        <li>
                            <a href="#">
                                <span class="photo"><img alt="avatar" src="<?=base_url()?>assets/images/avatar-mini.jpg"></span>
                                        <span class="subject">
                                            <span class="from">Greg  Martin</span>
                                            <span class="time">1 min</span>
                                        </span>
                                        <span class="message">
                                            I really like this admin panel.
                                        </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="photo"><img alt="avatar" src="<?=base_url()?>/assets/images/avatar-mini2.jpg"></span>
                                        <span class="subject">
                                            <span class="from">Bob   Mckenzie</span>
                                            <span class="time">5 mins</span>
                                        </span>
                                        <span class="message">
                                            Hi, What is next project plan?
                                        </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="photo"><img alt="avatar" src="<?=base_url()?>/assets/images/avatar-mini3.jpg"></span>
                                        <span class="subject">
                                            <span class="from">Phillip   Park</span>
                                            <span class="time">2 hrs</span>
                                        </span>
                                        <span class="message">
                                            I am like to buy this Admin Template.
                                        </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="photo"><img alt="avatar" src="<?=base_url()?>/assets/images/avatar-mini4.jpg"></span>
                                        <span class="subject">
                                            <span class="from">Ray   Munoz</span>
                                            <span class="time">1 day</span>
                                        </span>
                                        <span class="message">
                                            Icon fonts are great.
                                        </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">See all messages</a>
                        </li>
                    </ul>
                </li>
                <!-- inbox notificatoin end -->
                <!-- alert notification start-->
                <li id="alert_notificatoin_bar" class="dropdown" style="display:none">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                        <i class="icon-bell-l"></i>
                        <span class="badge bg-important">7</span>
                    </a>
                    <ul class="dropdown-menu extended notification">
                        <div class="notify-arrow notify-arrow-blue"></div>
                        <li>
                            <p class="blue">You have 4 new notifications</p>
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
                        </li>
                        <li>
                            <a href="#">See all notifications</a>
                        </li>
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
                        <i class="icon_star"></i>
                        <span>Project Nature</span>
                    </a>
                </li>
                <li class="sub-menu" id='reports'>
                    <a class="">
                        <i class="icon_desktop"></i>
                        <span>Reports</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li id='rproj'><a class="" href="projectschedule">Project Schedule</a></li>
                        <li id='rproj2'><a class="" href="equipmentstatus">Equipment Status</a></li>
                        <li id='rproj3'><a class="" href="projectload">Project Load</a></li>
                        <li id='rproj4'><a class="" href="personnel">Personnel Involved</a></li>
                        <li id='rproj6' ><a class="" href="budgetreport">Budget Report</a></li>
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

</script>
</body>
</html>

