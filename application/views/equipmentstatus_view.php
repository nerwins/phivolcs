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
							</header>
							<div class="container">
								<div class="col-md-3">
                                    <strong>Date From:</strong>
                                    <input id="datefrom" type="text" class="form-control" placeholder="Date From">
                                </div>

                                <div class="col-md-3">
                                    <strong>Date To:</strong>
                                    <input id="dateto" style="margin-bottom:20px"  type="text" class="form-control" placeholder="Date To">
                                </div>
                                <br>
                                <table id="etable" style="margin-top:10px;display:none" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td colspan="7" ><center><h4 id="rtitle"></h4></center></td>
                                    	</tr>
	                                    <tr>
	                                        <th>Item ID</th>
	                                        <th>Item Name</th>
	                                        <th>Project Assigned To</th>
	                                        <th>Project Duration</th>
	                                        <th>Return Date</th>
	                                        <th>Qty</th>
	                                        <th>Signed by</th>
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