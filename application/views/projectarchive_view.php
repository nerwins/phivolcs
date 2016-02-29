<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:35 PM
 */
require_once("assets/includes.php");
require_once($page_javascript);
require_once("assets/sidebar.php");
?>
<style>
    .progress {
        text-align:center;
        width:100%;
        margin:15px auto;
    }
    .progress-value {
        position:absolute;
        right:0;
        left:0;
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Project List
                        <button class="btn btn-default"  style="margin-top: -7px; margin-right: 9px;margin-bottom:-10px;" type="button" data-toggle="collapse" data-target="#filterdiv"><i class="icon_search"></i> Filters</button>
                        </header>
                        <div id="filterdiv" class="in" style="height: auto;">
                            <section class="panel">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Project Name:</strong>
                                            <div id="projectnamediv"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Location:</strong>
                                            <div id="projectlocationdiv"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Priority Level:</strong>
                                            <select id="projectlevel" class="form-control">
                                                <option value="0">All</option>
                                                <option value="1">Low</option>
                                                <option value="2">Medium</option>
                                                <option value="3">High</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Date From:</strong>
                                            <input type="text" class="form-control" placeholder="Date From" id="datefrom" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Date To:</strong>
                                            <input style="margin-bottom:20px"  type="text" class="form-control" placeholder="Date To" id="dateto" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-info form-control" id="searchButton">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    <label class="alert alert-danger" id="projectalert" style="width:100%;text-align:center;display:none;">No Records Found</label>
                    <label class='alert alert-success' id='projectapproved' style='width:100%;text-align:center;display:none'>Project Approved!</label>
                    <label class='alert alert-success' id='revisionapproved' style='width:100%;text-align:center;display:none'>Revisions Approved!</label>
                    <label class='alert alert-success' id='projectdeclined' style='width:100%;text-align:center;display:none'>Project Declined!</label>
                    <div id="projecttemp" style="display:none">
                        <table class="table table-striped table-advance table-hover" id="projecttable" style="text-align:center">
                            <thead>
                            <th style="text-align:center" style="display:none;">id</th>
                            <th style="text-align:center"><i class="icon_group"></i> Project Name</th>
                            <th style="text-align:center"><i class="icon_calendar"></i> Duration</th>
                            <th style="text-align:center"><i class="icon_datareport_alt"></i> Priority Level</th>
                            <th style="text-align:center"><i class="icon_pin_alt"></i> Location</th>
                            <th style="text-align:center"><i class="icon_cloud"></i> Progress</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>