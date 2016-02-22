<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/19/2016
 * Time: 7:36 PM
 */

require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript);  ?>
<style>
/*for testing purposes only*/
    #main-content {
        margin-top: 5%;
    }
    #buttoncontainer{
    	text-align: right;
    	margin-top: 15px;
    	margin-bottom: 20px;
    	margin-right: 15px;
    }
    #map-canvas {
        height: 400px;
        width:100%;
        margin: 0px;
        padding: 0px
    }
    .control-label {
    	font-weight: bold;
    }
    .help-block {
    	font-style: italic;
    }
    .panel-heading {
    	font-weight: bold;
    	font-size: 16px;
    }
    .btn-info {
    	margin-top: -3px;
    }
    #btnObjPlus{
    	margin: 0px;
    }
    #divObj{
    	margin-left: -15px;
    }
   /* #btnAddObjective{
    	margin-top: 2px;
    	margin-left: 80px;
    }*/
    #floating-panel {
	  position: absolute;
	  bottom: 20px;
	  left: 5%;
	  z-index: 5;
	  background-color: #fff;
	  padding: 5px;
	  border: 1px solid #999;
	  text-align: center;
	  font-family: 'Roboto','sans-serif';
	  font-size: 10px;	
	  line-height: 30px;
	  padding-left: 10px;
	}

</style>

<section id="main-content">
	<section id="wrapper">
		<div id = "buttoncontainer">
			<button class="btn btn-success" id="btnSaveAsDraft"><i class='icon_archive_alt'></i>&nbsp;Save as Draft</button>
			<button class="btn btn-primary" id="btnLoadDraft"><i class='icon_paperclip'></i>&nbsp;Load Draft</button>
		</div>
		<div class="row state-overview">
			<div class="col-md-12">
				<div class="col-md-12">
					<section class="panel">
					<header class="panel-heading">Project Overview</header>
					<div class="panel-body">
						<form class="form-horizontal">
							<fieldset>
						   		<div class="form-group">
						   			<label for="projectName" class="col-md-2 control-label">Project Name</label>
						   			<div class="col-md-8">
							        	<input type="text" class="form-control" id="projectName" placeholder="Project Name">
							      	</div>
						   		</div>
						   		<div class="form-group">
						   			<label for="projectType" class="col-md-2 control-label">Project Type</label>
						   			<div class="col-md-8">
							        	<select class="form-control" id="projectTypeSelect" placeholder="Project Type"> <!-- code for project types --> </select>
							      	</div>
						   		</div>
						   		<!-- <div class="form-group">
							      	<label for="projectObjective" class="col-md-2 control-label">Objective/s</label>
							      	<div class="col-md-8">
							      		<div class="col-md-10" id="divObj">
							      			<input class="form-control" id="asd" rows="3" placeholder="This project aims to...">
							      		</div>
							      		<div id="btnObjPlus" class="col-md-2">
							      			<button class="btn btn-info" id="btnAddObjective"><i class="icon_plus_alt2"></i></button> 
							      		</div>
							      	</div>
							      	
						   		</div> -->
						   		<div class="form-group">
						   			<label for="projectDuration" class="col-md-2 control-label">Duration</label>
						   			<div class="col-md-8" id="projectDuration">
						   				<div class="form-group">
											<div class="col-md-4">
												<label for="durationFrom" class="col-md-2 control-label">From</label>
												<input class="form-control" id="projectDurationFrom" rows="3" placeholder="From...">
							        		</div>
							        		<div class="col-md-4">
							        			<label for="durationTo" class="col-md-2 control-label">To</label>
												<input class="form-control" id="projectDurationTo" rows="3" placeholder="To...">
							        		</div>
						   				</div>
							      	</div>
						   		</div>
						  	</fieldset>
						</form>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> 
						Project Objectives
						<button class="btn btn-info pull-right" id="btnAddObjective"><i class="icon_plus_alt2"></i></button> 
					</header>
					<div class="panel-body">
						<table class="table table-hover" id="objectiveTable" style="text-align:center">
							<thead> 
								<tr> 
									<th style="text-align:center">Objective</th> 
									<th></th> 
								</tr> 
							</thead> 
							<tbody> 

							</tbody>
						</table>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> Project Specifics</header>
					<div class="panel-body">
						<form class="form-horizontal">
							<fieldset>
								<div class="form-group">
						   			<label for="projectHead" class="col-md-2 control-label">Project Head</label>
						   			<div class="col-md-8">
						   				<div class="form-group">
											<div class="col-md-8">
												<input type="text" class="form-control" id="projectHead" placeholder="Last Name, First Name">
							        		</div>
							        		<div class="col-md-2">
							        			<button class="btn btn-primary">Recommendation</button>
							        		</div>
							        		<div class="col-md-2">
							        			<button class="btn btn-success pull-right">Search</button>
							        		</div>
							        		<div class="col-md-8">
							        			<span class="help-block">Choose from a list of recommended employees, use the advanced search, or simply type your desired employee name</span>
							        		</div>
						   				</div>
							      	</div>
						   		</div>
						   		<div class="form-group">
						   			<label for="projectPriorityLevel" class="col-md-2 control-label">Priority Level</label>
						   			<div class="col-md-8">
										<select class="form-control" id="projectPriorityLevel" placeholder="Priority Level">
											<option value='1'>Low</option>
		                                    <option value='2'>Medium</option>
		                                    <option value='3'>High</option>
		                                    <option value='4'>Emergency</option>
										</select>
							      	</div>
						   		</div>
						   		<div class="form-group">
						   			<label for="projectDescription" class="col-md-2 control-label">Description</label>
						   			<div class="col-md-8">
										<textarea class="form-control" id="projectDescription" rows="3" placeholder="Description..."></textarea>
							      	</div>
						   		</div>
						   		<div class="form-group">
						   			<label for="projectBackground" class="col-md-2 control-label">Project Background</label>
						   			<div class="col-md-8">
										<textarea class="form-control" id="projectBackground" rows="3" placeholder="Background..."></textarea>
							      	</div>
						   		</div>
						   		<div class="form-group">
						   			<label for="projectLocation" class="col-md-2 control-label">Location</label>
							   			<div class="col-md-8" id="projectLocation">
							   				<!-- <button class='btn btn-success' id='backcenter'><i class='icon_globe'></i>&nbsp;Back to Center</button>
			                                <button class='btn btn-danger' onclick='addMarker();'><i class='icon_pin_alt'></i>&nbsp;Plot Location</button>
			                                <button class='btn btn-warning' onclick='checkCenter();'><i class='icon_compass'></i>&nbsp;Go to Location</button>
			                                <input id="pac-input" class="form-control"  type="text" placeholder="Search Location"> -->
								   			<div id="floating-panel">
								   				<div class="form-group">
								   					<label for="map-address" class="col-md-2 control-label">Location</label>
								   					<div class="col-md-10">
								   					<input class="form-control" id="map-address" type="textbox" value="Manila, PH">
								   				</div>
								   				</div>
								   				<div class="form-group">
								   					<label for="map-latitude" class="col-md-2 control-label" >Latitude</label>
								   					<div class="col-md-10">
								   					<input class="form-control" id="map-latitude" type="textbox" value="" readonly>
								   				</div>
								   				</div>
								   				<div class="form-group">
								   					<label for="map-longitude" class="col-md-2 control-label" >Longitude</label>
								   					<div class="col-md-10">
								   					<input class="form-control" id="map-longitude" type="textbox" value="" readonly>
								   				</div>
								   				</div>
								   				<div class="form-group">
								   					<div class="col-md-12">
								   						<div class="col-md-4">
								   							<input id="map-search" class="form-control btn btn-success btn-xs" type="button" value="Search">
								   						</div>
								   						<div class="col-md-4">
								   							<input id="map-submit" class="form-control btn btn-primary btn-xs" type="button" value="Submit">
								   						</div>
								   						<div class="col-md-4">
								   							<input id="map-reset" class="form-control btn btn-danger btn-xs" type="button" value="Reset">
								   						</div>
								   				</div>
								   				</div>
      											
								   			</div>
								   			<div id="map-canvas">
								   				
								   			</div>
							   			</div>
						      	</div>
						      	<div class="form-group">
						   			<label for="projectSignificance" class="col-md-2 control-label">Significance of the Project</label>
						   			<div class="col-md-8">
						   				<textarea class="form-control" id="projectSignificance" rows="3" placeholder="Significance of the Project..."></textarea>
						   			</div>
						      	</div>
							</fieldset>
						</form>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> 
						Project Output
						<button class="btn btn-info pull-right" id="btnAddOutput"><i class="icon_plus_alt2"></i></button> 
					</header>
					<div class="panel-body">
						<table class="table table-hover" id="outputTable" style="text-align:center">
							<thead> 
								<tr> 
									<th style="text-align:center">Expected Output</th>
									<th style="text-align:center">Performance Indicator</th> 
									<th></th> 
								</tr> 
							</thead> 
							<tbody> 

							</tbody>
						</table>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> 
						Budget Proposal
						<button class="btn btn-info pull-right" id="btnAddBudget"><i class="icon_plus_alt2"></i></button> 
					</header>
					<div class="panel-body">
						<table class="table table-hover" id="budgetTable" style="text-align:center">
							<thead> 
								<tr>
									<th style="text-align:center">Budget Item</th>
									<th style="text-align:center">Expense Type</th>
									<th style="text-align:center">Quantity</th>
									<th style="text-align:center">Amount</th>
									<th style="text-align:center">Total</th>
									<th></th> 
								</tr>
							</thead>	
							<tbody>

							</tbody>
							<tfoot>
	                            <tr>
	                                <th style="text-align:right" colspan="3">Grand Total :</th>
	                                <td id="totalamount"></td>
	                            </tr>
	                        </tfoot>
						</table>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> 
						 
					</header>
					<div class="panel-body ">
						<div style="text-align:center">
							<button class="btn btn-success" id="btnProceed">Proceed to Work Plan</button>
						</div>
						<div style="text-align:center; padding-top: 10px;">
							<button class="btn btn-warning" id="btnResetForm">Reset</button>
						</div>
					</div>
				</section>
				</div>
			</div>
		</div>
	</section>
</section>

<div id="modalSaveAsDraft" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon_close"></i></button>
        <h4 class="modal-title">Save As Draft</h4>
      </div>
      <div class="modal-body">
        <form role="form">
            <div class="form-group">
              <label for="draftName"> Draft Name</label>
              <input type="text" class="form-control" id="draftName" placeholder="">
            </div>
              <button type="submit" id="btnSubmitDraft" class="btn btn-success btn-block">Save Draft</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>