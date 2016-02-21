<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:41 PM
 */

require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript); 
?>
<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="container">
						<section class="panel">
							<header class="panel-heading">
								Project Load Comparison
							</header>
							<div class="container">
								<div class="col-md-12">
									<div class="col-md-12">
										<strong>Employee:</strong>
										<div class="row">
										<div id="employeesdiv" class="col-md-11"></div>
										<div class="col-md-1"><button class="btn btn-success" id="reset" style="display:none;">Reset</button></div></div>
									</div>
                                    <table id="ploadtable" style="margin-top:10px;display:none" class="table table-bordered table-hover table-striped">
                                        <thead>
	                                        <th>Employee Name</th>
	                                        <th>Projects Involved</th>
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
