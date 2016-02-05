<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:35 PM
 */
require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript);
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
                    </header>
                    <label class="alert alert-danger" id="projectalert" style="width:100%;text-align:center;display:none;">No Records Found</label>
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