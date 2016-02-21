<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:41 PM */
require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript); 
?>

 <section id="main-content">
 	<section class="wrapper">
 		<div class="row">
 			<div class="container">
 				<div class="col-lg-12">
 					<div class="row">
 						<section class="panel">
 							<header class="panel-heading">
                                Personnel for Projects
                            </header>
                            <div class="container">
                            	<div class="col-md-12">
                            		<div class="row">
                            			<div class="col-md-12">
                            				<strong>Employee:</strong><div id="employeesdiv"></div>
                            			</div>
                            		</div>
                            		<div class="row">
	                            		<div class="col-md-3">
	                                        <strong>Date From:</strong>
	                                        <input id="datefrom" type="text" class="form-control" placeholder="Date From" readOnly>
	                                    </div>
	                                    <div class="col-md-3">
	                                        <strong>Date To:</strong>
	                                        <input id="dateto" style="margin-bottom:20px"  type="text" class="form-control" placeholder="Date To" readOnly>
	                                    </div>
                                    </div>
                                    <table id="personneltable" style="margin-top:10px;display:none" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <td colspan="5"><center>Personnel Involved Per Project</center></td>
                                        	</tr>
	                                        <tr>
	                                            <th style="text-align:center;">Project Name</th>
	                                            <th style="text-align:center;">Priority</th>
	                                            <th style="text-align:center;">Location</th>
	                                            <th style="text-align:center;">Date</th>
	                                            <th style="text-align:center;">Employees Involved</th>
	                                        </tr>
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