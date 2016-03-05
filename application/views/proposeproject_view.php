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
	.task-list {
	  width: 300px;
	  float: left;
	  margin: 0 5px;
	  background-color: #e3e3e3;
	  min-height: 240px;
	  border-radius: 10px;
	  padding-bottom: 15px;
	}
	.task-container {
	 margin: auto;
	 width: 60%;
	 padding: 10px;
	}

	#add-task-container {
		width: 100%;
	}
	.chosen-container {
		left: 5px;
	}
	/*.add-task {
	  background-color: #374a5d;
	}*/

	.btnAddTask {
		text-align: center;
	}

	.btnAddEquip {
		text-align: center;
		margin-bottom: 30px;
	}
	.task-list input, .task-list textarea, .task-list select {
	  width: 290px;
	  margin: 1px 5px;
	}

	.task-list input, .task-list select {
	  height: 30px;
	}
	.task-list label {
		margin-left: 5px;
		margin-top: 10px;
	}

	.todo-task {
	  border-radius: 5px;
	  background-color: #fff;
	  width: 290px;
	  margin: 5px;
	  padding: 5px;
	}

	.task-list input[type="button"] {
	  width: 200px;
	  margin: 5px;
	}

	.todo-task > .task-header {
	  font-weight: bold;
	}

	.todo-task > .task-date {
	  font-size: small;
	  font-style: italic;
	}

	.todo-task > .task-description {
	  font-size: smaller;
	}

	.todo-task > .task-view {
	  text-align: right;
	  color: blue;
	}
	.todo-task > .task-view:hover {
	  color:cyan; 
	  background-color:transparent; 
	  text-decoration:underline
	}

	h3 {
	  text-align: center;
	}

	#eqName{
		width: 200px;
		margin-left: -10px;
	}

	.chosen-select {
		width: 100px;
	}

	#eqQty {
		width: 80px;
		/*margin-left: 210px;*/
	}

	#delete-div {
	  background-color: #fff;
	  border: 3px dotted #000;
	  margin: 10px;
	  height: 75px;
	  line-height: 75px;
	  text-align: center;
	}
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
	.selected {
    background-color: gray;
    color: #FFF;
	}
	.errorDiv {
		margin-top: -10px;
		width: 100%;
	}
	.errorLabel {
		text-align: center;
		display: none;
		font-size: small;
		padding-top: 10px;
		padding-bottom: 10px;
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
					<div class="errorDiv alert-danger">
						<label class="errorLabel" id="errorProjectName">Please supply a project name</label>
						<label class="errorLabel" id="errorDurationFrom">Invalid Date:From</label>
						<label class="errorLabel" id="errorDurationTo">Invalid Date:To</label>
					</div>
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
					<div class="errorDiv alert-danger">
						<label class="errorLabel" id="errorObjective">Please supply a valid project objective</label>
					</div>
					<div class="panel-body">
						<table class="table table-hover" id="objectiveTable" style="text-align:center">
							<thead> 
								<th style="text-align:center">Objective</th> 
								<th></th> 
							</thead> 
							<tbody> 

							</tbody>
						</table>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> Project Specifics</header>
					<div class="errorDiv alert-danger">
						<label class="errorLabel" id="errorProjectHead">Project Head does not exist</label>
						<label class="errorLabel" id="errorDescription">Please provide a valid description</label>
						<label class="errorLabel" id="errorBackground">Please provide a valid project background</label>
						<label class="errorLabel" id="errorLocation">Invalid location, please make sure all fields are filled out</label>
						<label class="errorLabel" id="errorSignificance">Please provide a valid entry in the 'Significance of the Project' section</label>
					</div>
					<div class="panel-body">
						<form class="form-horizontal">
							<fieldset>
								<div class="form-group">
						   			<label for="projectHead" class="col-md-2 control-label">Project Head</label>
						   			<div class="col-md-8">
						   				<div class="form-group">
											<div class="col-md-10">
												<input type="text" class="form-control" id="projectHead" placeholder="Last Name, First Name">
							        		</div>
							        		<div class="col-md-2">
							        			<button class="btn btn-primary" id="btnRecommendation" type="button">Recommendations</button>
							        		</div>
							        		<!-- <div class="col-md-2">
							        			<button class="btn btn-success pull-right">Search</button>
							        		</div> -->
							        		<div class="col-md-8">
							        			<span class="help-block">Choose from a list of recommended employees or simply type your desired employee name</span>
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
					<div class="errorDiv alert-danger">
						<label class="errorLabel" id="errorOutput">Please provide a valid project output</label>
					</div>
					<div class="panel-body">
						<table class="table table-hover" id="outputTable" style="text-align:center">
							<thead> 
								<tr> 
									<th style="text-align:center">Expected Output</th>
									<th style="text-align:center">Performance Indicator</th> 
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
					<div class="errorDiv alert-danger">
						<label class="errorLabel" id="errorBudget">Please provide a valid proposed budget item</label>
					</div>
					<div id="budgetContainer" class="panel-body">
						<table class="table table-hover" id="budgetTable" style="text-align:center">
							<thead> 
								<tr>
									<th style="text-align:center">Expense Type</th>
									<th style="text-align:center">Budget Item</th>
									<th style="text-align:center">Reason</th>
									<th style="text-align:center">Quantity</th>
									<th style="text-align:center" id="expenseHeader">Amount</th>
									<th style="text-align:center">Total</th>
									<th></th> 
								</tr>
							</thead>	
							<tbody>

							</tbody>
							<tfoot>
	                            <tr>
	                                <th style="text-align:right" colspan="5">Grand Total :</th>
	                                <td id="totalamount"></td>
	                            </tr>
	                        </tfoot>
						</table>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> 
						Tasks
					</header>
					<div class="errorDiv alert-danger">
						<label class="errorLabel" id="errorTasks">Tasks List cannot be empty</label>
					</div>
					<div id="" class="panel-body">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="task-list" id="pending">
							  <h3>Tasks List</h3>
							  <!-- Sample task added manually to check look -->
							  <!-- <div class="todo-task">
								  <div class="task-header">Sample Header</div>
								  <div class="task-date">25/06/1992</div>
								  <div class="task-description">Lorem Ipsum Dolor Sit Amet</div>
							  </div> -->
						  </div>
						</div>
						<div class="col-md-8">
							<div class="task-list add-task" id="add-task-container">
							  <h3>Add a task</h3>
							  <div class="errorDiv alert-danger">
							  	<label class="errorLabel" id="errorTaskName">Task Name cannot be empty</label>
							  	<label class="errorLabel" id="errorTaskSkillset">Skillset cannot be empty</label>
							  	<label class="errorLabel" id="errorTaskMilestone">Milestone Indicator cannot be empty</label>
							  	<label class="errorLabel" id="errorTaskOutput">Output cannot be empty</label>
							  	<label class="errorLabel" id="errorTaskDueDate">Due Date cannot be empty</label>
							  	<label class="errorLabel" id="errorTaskEmployee">Please assign this task to a valid employee</label>
							  </div>
								  <div class="col-md-6">
								  	<input type="text" placeholder="Task Name" class="form-control" id="task_name"/>
								    <select class="form-control" id="taskPriorityLevel" placeholder="Priority Level">
										<option value='1'>Low</option>
			                            <option value='2'>Medium</option>
			                            <option value='3'>High</option>
			                            <option value='4'>Emergency</option>
									</select>
									<select data-placeholder="Skillsets" class="chosen-select" multiple tabindex="6" id=taskSkillset>
									</select>
								    <!-- <input type="text" id="taskSkillset" placeholder="Skillsets" class="form-control" /> -->
								    <textarea placeholder="Milestone Indicator" class="form-control" id="taskMilestone"></textarea>
								    <textarea placeholder="Output" class="form-control" id="taskOutput"></textarea>
								    <input type="text" id="duedate" placeholder="Due Date (dd/mm/yyyy)" class="form-control" />
							  </div>
							  <div class="col-md-6">
							  	<div class="">
							  		<label for="" class="control-label">Assigned to</label>
							  		<button type="button" class="btn btn-success" id="btnViewRec" > 
							  			 <i class="icon_plus_alt2"></i>
							  		</button>
						    		<!-- <input type="button"  value="Add" /> -->
						    	</div>
						    	<table class="table table-hover" id="assignedEmployees" style="text-align:center">
									<thead> 				
									</thead> 
									<tbody> 
									</tbody>
								</table>
								<div>
									<label for="" class="control-label">Equipment</label>
									<!-- <input  value="Add" /> -->
								</div>
								<div id="equipmentInputs" class="col-md-12">
									<div class="col-md-8">
										<input type="text" placeholder="Name" class="form-control" id="eqName" />
									</div>
									<div class="col-md-4">
										<input class="form-control" id="eqQty" placeholder="Qty" type="number" min="1" max="99" value=1>
									</div>
								</div>
								<table class="table table-hover" id="taskEquipment" style="text-align:center">
									<thead> 
										<tr> 
										</tr> 
									</thead> 
									<tbody> 
										<tr>
										</tr>
									</tbody>
								</table>
								<div class="btnAddEquip">
								<button type="button" class="btn btn-success" id="btnAddEquipment">Add</button>
							</div>
						    <div class="btnAddTask">
						    	<input type="button" class="btn btn-primary" id="btnAddTask" value="Add Task" />
						    </div>
							  </div>
							<!-- <input type="text" placeholder="" class="form-control" id="assignedEmployee" /> -->

						  <div id="delete-div" style="display:none;">Drag Here to Delete</div>
						</div>
						</div>
					</div>
						<div class="task-container">

						
						</div>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading"> 
						 
					</header>
					<div class="panel-body ">
						<div style="text-align:center">
							<button class="btn btn-success" id="btnProceed">Proceed</button>
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

<div id="modalSaveAsDraft" class="modal fade" role="dialog">
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

<div id="modalRecommendation" class="modal fade">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon_close"></i></button>
        <h4 class="modal-title">Recommendations</h4>
      </div>
      <div class="modal-body">
      <table class="table table-hover" id="recommendationTable" style="text-align:center">
			<thead> 
				<tr> 
					<th style="text-align:center">Name</th> 
					<th style="text-align:center">Division</th>
					<th style="text-align:center">Date Started</th>
					<th style="text-align:center">Skillset</th>
					<th style="text-align:center">Projects Involved</th>
					<th style="text-align:center">Projects Handled</th>
					<th></th> 
				</tr> 
			</thead> 
			<tbody> 
				<tr>
				</tr>
			</tbody>
		</table>
      	<button id="btnSubmitRecommendation" class="btn btn-success btn-block save">Submit</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="modalViewTask" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon_close"></i></button>
        <h4 class="modal-title">Task</h4>
      </div>
      <div class="modal-body">
      	<button id="" class="btn btn-success btn-block save">Submit</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>