<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/15/2016
 * Time: 7:25 PM
 */
require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript);  ?>
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
    #main-content {
        margin-top: 5%;
    }
    .th {
        font-weight: normal;
        font-size: 5px;
    }
    #gray {
        /*font-size: 5px;*/
        color: rgb(128,128,128);
    }
</style>
<section id="main-content">
    <section id="wrapper">
        <div class="row state-overview">
            <div class="col-md-12">
                <div class="col-md-5">
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
                                    <p id='empname'>Welcome back , <?=$_SESSION['fullname'];?>. Please check your pending work.</p>

                                    <h6>
                                        <span><i class="icon_clock_alt"></i><span id="ct"></span></span>
                                        <span><i class="icon_calendar"></i><span id='dt'></span></span>
                                        <br> <span><i class="icon_pin_alt"></i><span id='division'> </span></span>
                                    </h6>
                                </div>
                                <div class="weather-category twt-category">
                                    <h4><i class='icon_globe'></i>&nbsp;Projects</h4>
                                    <div id="projectsCountTable">
                                        <ul id="projectsCountList">
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
                                </div>
                                <hr>
                                <div class="weather-category twt-category">
                                    <h4><i class='icon_book_alt'></i>&nbsp;Tasks</h4>
                                        <div id="tasksCountTable">
                                            <ul id="tasksCountList">
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
                                <div class="weather-category twt-category">
                                    <h4 id="membertasksTitle"><i class='icon_book_alt'></i>&nbsp;Tasks of Project Members</h4>
                                        <div class="membertasksCountTable">
                                             <ul id="membertasksCountList">
                                                <li class="active">
                                                    <h4 id='c1'></h4>
                                                    <i class="icon_close_alt2"></i> In Progress
                                                </li>
                                                <li>
                                                    <h4 id='c2'></h4>
                                                    <i class="icon_check_alt2"></i> Completed
                                                </li>
                                                <li>
                                                    <h4 id='c3'></h4>
                                                    <i class="icon_plus_alt2"></i> Total
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                            </div>
                            <footer class="profile-widget-foot">
                                <div class="follow-task">

                                </div>
                            </footer>
                        </div>
                    </section>
                    <section class="panel" style="display: none;">
                        <div class="panel-body project-team">
                            <div class="task-progress">
                                <h1>Projects in Due</h1>
                            </div>
                        </div>
                        <!-- <label class="alert alert-danger" id="projectalert" style="text-align: center;width:100%"></label> -->
                        <div id="projecttemp" style="">
                            <table class="table table-hover personal-task" id="projecttable" style='text-align:center;'>
                                <thead>
                                <th style="text-align:center">Project Name</th>
                                <th style="text-align:center">Due Date</th>
                                <th style="text-align:center">Priority</th>
                                <th style="text-align:center">Progress</th>
                                <!-- <th style="text-align:center">Proposed Budget</th>
                                <th style="text-align:center">Actual Budget</th> -->
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="col-md-7">
                    <section id="tasks" class='panel'>
                        <div class="panel-body project-team">
                            <div class="task-progress">
                                <h1>Tasks in Progress</h1>
                            </div>
                        </div>

                        <div id='calendar'></div>
                    </section>
                </div>
            </div>
        </div>
        <section class='panel' id="inventory" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <section class='panel'>
                            <div class="panel-body project-team">
                                <div class="task-progress">
                                    <h1>Inventory</h1>&nbsp;
                                </div>
                            </div>
                            <div id="filterdiv" class="in" style="height: auto;">
                                <section class="panel">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <!--<div class="col-md-6">
                                                Project Name:
                                                <div id="projectdiv"></div>
                                            </div>-->
                                            <div class="col-md-6">
                                                Equipment Name:
                                                <div id="equipmentdiv"></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <table class="table table-hover personal-task" id="inventorytable">
                                <thead>
                                <th style="text-align: center"></th>
                                <th style="text-align: center">Equipment Name</th>
                                <th style="text-align: center">Qty</th>
                                <th style="text-align: center">Qty in use</th>
                                <th style="text-align: center">Total Qty</th>
                                <th style="text-align: center">Average Price</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </section>
                    </div>
                    <div class="col-md-6">
                        <section class='panel'>
                            <div class="panel-body project-team">
                                <div class="task-progress">
                                    <h1>Equipment Tracking</h1>&nbsp;
                                </div>
                            </div>
                            <div id="filterdiv2" class="in" style="height: auto;">
                                <section class="panel">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Equipment Name:
                                                <div id="equipmentdiv2"></div>
                                            </div>
                                            <div class="col-md-4">
                                                Status:
                                                <select id="status">
                                                    <option value="0">All</option>
                                                    <option value="1">In Stock</option>
                                                    <option value="2">In Use</option>
                                                    <option value="3">Being Returned</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                Project Location:
                                                <div id="locationdiv"></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <table class="table table-hover personal-task" id="equipmenttable">
                                <thead>
                                <th style="text-align: center"></th>
                                <th style="text-align: center">ID</th>
                                <th style="text-align: center">Equipment Name</th>
                                <th style="text-align: center">Project Name</th>
                                <th style="text-align: center">Project Location</th>
                                <th style="text-align: center">Status</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
