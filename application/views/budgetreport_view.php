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
                            </header>
                            <div class="container">
                                <div id="filterdiv" class="collapse">
                                    <section class="panel">
                                        <div class="col-md-12">
                                            <div class="row">
                                            	<div class="col-md-3">
                                                    <strong>Date From:</strong>
                                                    <input type="text" class="form-control" placeholder="Date From" id="datefrom" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Date To:</strong>
                                                    <input style="margin-bottom:20px"  type="text" class="form-control" placeholder="Date To" id="dateto" readonly>
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
                                <div class="col-md-12">
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