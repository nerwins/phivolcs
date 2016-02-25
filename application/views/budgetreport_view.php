<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/23/2016
 * Time: 5:35 PM
 */
require_once("assets/includes.php");
require_once($page_javascript);
require_once("assets/sidebar.php");
?>

<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="container">
						<section class="panel">
							<header class="panel-heading">
                                Budget Report
                                <button class="btn btn-default"  style="margin-top: -7px; margin-right: 9px;margin-bottom:-10px;" type="button" id='skillfilterbutton' data-toggle="collapse" data-target="#filterdiv"><i class="icon_search"></i> Filters</button>
                                <button class="btn btn-send"  onclick="print()" style="float: right; margin-top: -7px; margin-right: 9px;margin-bottom:-10px;" type="button" id='print' data-toggle="collapse"><i class="icon_printer"></i> Print</button>
                            </header>
                            <div class="container">
                                <div id="filterdiv" class="in" style="height: auto;">
                                    <section class="panel">
                                        <div class="col-md-12">
                                            <div class="row">
                                            	<div class="col-md-3">
                                                    <strong>Date From:</strong>
                                                    <input type="text" class="form-control" id="datefrom" placeholder="DateFrom" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Date To:</strong>
                                                    <input style="margin-bottom:20px"  type="text" class="form-control" id="dateto" placeholder="DateTo" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>Project Division:</strong>
                                                    <select id="division" class="form-control">
                                                        <option value="0">All</option>
                                                        <option value="1">Volcanology</option>
                                                        <option value="2">Seismology</option>
                                                        <option value="3">Finance and Admin</option>
                                                        <option value="4">Research and Development</option>
                                                        <option value="5">Disaster Preparedness</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Project Nature:</strong>
                                                    <div id="naturesdiv"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div id="divprint" class="col-md-12">
                                	<table class="table table-bordered table-hover table-striped" id="budgettable" style="display:none;">
                                        <thead>
                                            <th style="text-align:center;">id</th>
                                            <th style="text-align:center;">Project Title</th>
                                            <th style="text-align:center;">Project Leader</th>
                                            <th style="text-align:center;">Project Division</th>
                                            <th style="text-align:center;">Proposed Budget</th>
                                            <th style="text-align:center;">Actual Expenses</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>