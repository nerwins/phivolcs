<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/15/2016
 * Time: 7:25 PM
 */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log In</title>
    <?php require_once("assets/includes.php");
    require_once("assets/sidebar.php");
    require_once($page_javascript);  ?>
</head>
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row state-overview">
            <div class="col-lg-5">
                <div class="col-lg-6">
                    <section class="panel">
                        <div class="profile-widget profile-widget-info">
                            <div class="panel-body">
                                <div class="col-lg-4 col-sm-4 profile-widget-name">
                                    <h4 id="empname"></h4>
                                    <div class="follow-ava">
                                        <img src="<?=base_url()?>/assets/images/profile-widget-avatar.jpg" alt="">
                                    </div>
                                    <h6 id="empposition"></h6>
                                </div>
                                <div class="col-lg-8 col-sm-8 follow-info">
                                    <p id='empname'>Welcome back , Please check your pending work.</p>

                                    <h6>
                                        <span><i class="icon_clock_alt"></i><span id="ct"></span></span>
                                        <span><i class="icon_calendar"></i><span id='dt'></span></span>
                                        <br> <span><i class="icon_pin_alt"></i><span id='division'> Department</span></span>
                                    </h6>
                                </div>
                                <div class="weather-category twt-category">
                                    <h4><i class='icon_globe'></i>&nbsp;Projects</h4>
                                    <ul>
                                        <li class="active">
                                            <h4 id='p1'></h4>
                                            <i class="icon_close_alt2"></i> In progress
                                        </li>
                                        <li>
                                            <h4 id='p2'></h4>
                                            <i class="icon_check_alt2"></i> Completed
                                        </li>
                                        <li>
                                            <h4 id='p3'></h4>
                                            <i class="icon_plus_alt2"></i> Total
                                        </li>
                                    </ul>
                                </div>
                                <div class="weather-category twt-category">
                                    <h4><i class='icon_globe'></i>&nbsp;Projects</h4>
                                    <ul>
                                        <li class="active">
                                            <h4 id='p1'></h4>
                                            <i class="icon_close_alt2"></i> In progress
                                        </li>
                                        <li>
                                            <h4 id='p2'></h4>
                                            <i class="icon_check_alt2"></i> Completed
                                        </li>
                                        <li>
                                            <h4 id='p3'></h4>
                                            <i class="icon_plus_alt2"></i> Total
                                        </li>
                                    </ul>
                                </div>
                                <div class="weather-category twt-category">
                                    <h4><i class='icon_globe'></i>&nbsp;Projects</h4>
                                    <hr>
                                    <ul>
                                        <li class="active">
                                            <h4 id='p1'></h4>
                                            <i class="icon_close_alt2"></i> For Revision
                                        </li>
                                        <li class="active">
                                            <h4 id='p1'></h4>
                                            <i class="icon_loading"></i> For Approval
                                        </li>
                                        <li>
                                            <h4 id='p2'></h4>
                                            <i class="icon_check_alt2"></i> Approved
                                        </li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="weather-category twt-category">
                                    <h4><i class='icon_book_alt'></i>&nbsp;Tasks</h4>
                                    <ul>
                                        <li class="active">
                                            <h4 id='t1'></h4>
                                            <i class="icon_close_alt2"></i> In Progress
                                        </li>
                                        <li>
                                            <h4 id='t2'></h4>
                                            <i class="icon_check_alt2"></i> Completed
                                        </li>
                                        <li>
                                            <h4 id='t3'></h4>
                                            <i class="icon_plus_alt2"></i> Total
                                        </li>
                                    </ul>
                                </div>
                                <div class="weather-category twt-category">

                                    <h4><i class='icon_book_alt'></i>&nbsp;Tasks of Project Members</h4>
                                    <ul>
                                        <li class="active">
                                            <h4 id='t1'></h4>
                                            <i class="icon_close_alt2"></i> In Progress
                                        </li>
                                        <li>
                                            <h4 id='t2'></h4>
                                            <i class="icon_check_alt2"></i> Completed
                                        </li>
                                        <li>
                                            <h4 id='t3'></h4>
                                            <i class="icon_plus_alt2"></i> Total
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <footer class="profile-widget-foot">
                                <div class="follow-task">

                                </div>
                            </footer>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body project-team">
                            <div class="task-progress">
                                <h1>Projects</h1>
                                <h1>Projects in Due</h1>
                            </div>
                        </div>
                        <label class="alert alert-danger" id="projectalert" style="display:none;text-align: center;width:100%"></label>
                        <div id="projecttemp" style="display:none">
                            <table class="table table-hover personal-task" id="projecttable" style='text-align:center;'>
                                <thead>
                                <th style="text-align:center">Project Name</th>
                                <th style="text-align:center">Due Date</th>
                                <th style="text-align:center">Priority</th>
                                <th style="text-align:center">Progress</th>
                                <th style="text-align:center">Proposed Budget</th>
                                <th style="text-align:center">Actual Budget</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="col-lg-6">
                    <section class='panel'>
                        <div class="panel-body project-team">
                            <div class="task-progress">
                                <h1>Tasks in Progress</h1>
                            </div>
                        </div>

                        <div id='calendar'></div>
                    </section>
                </div>
                <div class="col-lg-6">
                    <section class='panel'>
                        <div class="panel-body project-team">
                            <div class="task-progress">
                                <h1>Inventory</h1>
                            </div>
                        </div>

                        <table class="table table-hover personal-task" >
                            <thead>
                            <th style="text-align: center"><i class="icon_cart_alt"></i>&nbsp;Equipment Name</th>
                            <th style="text-align: center"><i class="icon_calculator_alt"></i>&nbsp;Qty</th>
                            <th style="text-align: center"><i class="icon_check_alt2"></i>&nbsp;Qty in use</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style='text-align:center'></td>
                                    <td style='text-align:center'></td>
                                    <td style='text-align:center'></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>
    </section>
</section>