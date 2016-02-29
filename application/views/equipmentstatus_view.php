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
								Equipment Status Report
								<button class="btn btn-default"  style="margin-top: -7px; margin-right: 9px;margin-bottom:-10px;" type="button" id='filterbutton' data-toggle="collapse" data-target="#filterdiv"><i class="icon_search"></i> Filters</button>

							</header>
							<div class="container">
								<div id="filterdiv" class="in" style="height: auto;">
									<section class="panel">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-3">
													<strong>Equipment Name:</strong>
													<div id="equipmentdiv"></div>
												</div>
												<div class="col-md-3">
													<strong>Return Date:</strong>
													<input id="returndate" type="text" class="form-control" placeholder="Date From" readonly>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<strong>Status:</strong>
													<select id="status">
														<option value="0">All</option>
														<option value="1">In Stock</option>
														<option value="2">In Use</option>
														<option value="3">Being Returned</option>
													</select>
												</div>
												<div class="col-md-3">
													<strong>Project Assigned To:</strong>
													<div id="projectdiv"></div>
												</div>
											</div>
										</div>
									</section>
								</div>
                                <br>
                                <table id="etable" style="margin-top:10px;display:none" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td colspan="7" ><center><h4 id="rtitle"></h4></center></td>
                                    	</tr>
	                                    <tr>
	                                        <th>Item ID</th>
	                                        <th>Equipment Name</th>
	                                        <th>Status</th>
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