<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:40 PM
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
								Notifications
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
										</div>
									</section>
								</div>
                                <br>
                                <div id="markall" align="right" style="display:none;"><a onclick='markallread();' style='text-align:right; cursor:pointer;'>Mark All as Read</a></div>
                                <table id="ntable" style="margin-top:10px;display:none" class="table table-bordered table-hover table-striped">
                                    <thead>
	                                    <tr>
	                                        <th width="120px">Date Time</th>
	                                        <th>Notification</th>
	                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>