<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/04/2016
 * Time: 7:42 PM
 */
require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript);?>
?>

<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-lg-12">
				<div class="profile-widget profile-widget-info">
					<div class="panel-body">
						<div class="col-lg-2 col-sm-2">
							<h4><div id="projectHeadName"></div></h4>
							<div class="follow-ava">
                                <img src="<?=base_url()?>/assets/images/profile-widget-avatar.jpg" alt="">
                            </div>
                            <h6>Project Head</h6>
                            <div id="projecthead">
                            		
                            </div>
						</div>
						<div class="col-lg-4 col-sm-4 follow-info"> 
                            <p>Project Name: &nbsp;<strong id="pname"></strong></p>

                            <p>Project Priority:&nbsp;<span id="pstatus"></span> </p>
                            <p>Project Status:&nbsp;<span id="projstatus"></span></p>
                            <p id="budget"></p>
                            <p>Project Duration:</p>
                            <h6>
                                <span><i class="icon_calendar"></i> From:<span id="datefrom"></span></span>
                                <span><i class="icon_calendar"></i> To:<span id="dateto"></span></span>
                            </h6>
                            <br>
                        </div>
                        <div class="col-lg-6 col-sm-6 follow-info weather-category">
                            <ul>
                                <li class="active">
                                    <h4 id="ptask"></h4>
                                    <i class="icon_close_alt2"></i> Pending Task
                                </li>
                                <li>
                                    <h4 id="ctask"></h4>
                                    <i class="icon_check_alt2"></i> Completed
                                </li>
                                <li>
                                    <h4 id="ttask"></h4>
                                    <i class="icon_plus_alt2"></i> Total Task
                                </li>
                            </ul>
                            <div style="float:left;"><button style="display:none;" class='btn btn-success' id='redirectButton1' title='View End of Summary Report' onclick='showRedirect(0);'><i class='icon_datareport_alt'></i> View End of Summary Report</button>&nbsp;</div>
                            <div style="float:left;"><button style="display:none;" class='btn btn-danger' id='redirectButton2' title='View Progress Reports' onclick='showRedirect(1);' hidden><i class='icon_percent_alt'></i> View Progress Reports</button>&nbsp;</div>
                            <div style="float:left;"><button style="display:none;" class='btn btn-warning' id='redirectButton3' title='View tasks for project' onclick='showRedirect(2);' hidden><i class='icon_lightbulb_alt'></i> View tasks for project</button>&nbsp;</div>
                            <div style="float:left;"><button style="display:none;" class='btn btn-danger' id='redirectButton4' title='Make Project Team' onclick='showRedirect(3);' hidden><i class='icon_group'></i> Make Project Team'</button>&nbsp;</div>
                            <div style="float:left;"><button style="display:none;" class='btn btn-success' id='redirectButton5' title='Declare Project as Done' onclick='showRedirect(4)' hidden><i class='icon_box-checked'></i> Declare Project as Done</button></div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading tab-bg-info">
						<ul class="nav nav-tabs">
							<li class="active">
                                <a data-toggle="tab" href="#recent-activity">
                                    <i class="icon-home"></i>
                                    Details
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id='gantttab' href="#gantt">
                                    <i class="icon-user"></i>
                                    <span id="gantttitle"></span>
                                </a>
                            </li>
                            <li class="">
                                <a id='maptab' data-toggle="tab" href="#edit-profile" >
                                    <i class="icon-envelope"></i>
                                    <span id="projmap"></span>
                                </a>
                            </li>
                            <div id="projectexpense">
                            </div>
						</ul>
					</header>
					<div class="panel-body">
						<div class="tab-content">
							<div id="gantt" class="tab-pane">
                                <div id="ganttChart"></div>
                                <br/><br/>
                            </div>
                            <div id="recent-activity" class="tab-pane active">
                            	<section class="panel">
                            		<div class="bio-graph-heading3">									  
                                        <div style="margin-top: -10px; margin-bottom:10px">
                                            <h4 style="text-align:center;">Project Description:&nbsp;<button class='btn btn-success' id='section1'><i class='icon_pencil-edit'></i></button><button class='btn btn-warning' id='rev1' onclick='addComment(this, 1)' title='Revise'><i class='icon_clipboard'></i></button></h4>
                                            <div id="pdescription"></div>
                                        </div>
                                    </div>
                                    <div id='hiddenbudget'>
                                    	<div class="span12"><hr></div>	
                                    	<div class="bio-graph-heading3">	
                                            <div style="margin-top: -10px; margin-bottom:10px;">
                                                <h4 style="text-align:center;">Project Objectives:&nbsp;<button class='btn btn-success' id='section2'><i class='icon_plus_alt2'></i></button><button id='rev2' class='btn btn-warning' onclick='addComment(this, 2)' title='Revise'><i class='icon_clipboard'></i></button></h4>
                                                <ol id="pobjectives" style='text-align: center; list-style-position:inside;'></ol>
                                            </div>
                                        </div>
                                        <div class="span12"><hr></div>
                                        <div class="bio-graph-heading3">
                                            <div style="margin-top: -10px; margin-bottom:10px">
                                                <h4>Project Background:&nbsp;<button class='btn btn-success' id='section3'><i class='icon_pencil-edit'></i></button><button class='btn btn-warning' id='rev3' onclick='addComment(this, 3)' title='Revise'><i class='icon_clipboard'></i></button></h4>
                                                <div id="pbackground"></div>
                                            </div>
                                        </div>
                                        <div class="span12"><hr></div>
                                        <div class="bio-graph-heading3">
                                            <div style="margin-top: -10px; margin-bottom:10px">
                                                <h4 style="text-align:center;">Significance of the Project:&nbsp;<button class='btn btn-success' id='section4'><i class='icon_pencil-edit'></i></button><button  id='rev4' class='btn btn-warning' onclick='addComment(this, 4)' title='Revise'><i class='icon_clipboard'></i></button></h4>
                                                <div id="psignificance"></div>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="span12"><hr></div>
                                    <div class="bio-graph-heading3"> 
                                    	<h4 style="text-align:center;">Work Plan:&nbsp;<button class='btn btn-success' id='section5'><i class='icon_plus_alt2'></i></button><button class='btn btn-warning' id='rev5' onclick='addComment(this, 5)' title='Revise'><i class='icon_clipboard'></i></button></h4>
                                    	<table class="table  table-advance table-hover" id="tasktable" style="text-align:center">
                                            <thead>
                                                <th style="display:none">id</th>
	                                            <th style="text-align:center">Major Activity</th>
	                                            <th style="text-align:center">Milestone</th>
	                                            <th style="text-align:center">Indication Date</th>
                                                <th style="display:none">Member Count</th>
	                                            <th style="text-align:center">Priority Level</th>
                                                <th style="text-align:center">Output</th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="span12"><hr></div>
                                    <div class="bio-graph-heading3" id="pbudget">
                                    	<h4 style="text-align:center;">Project Budget:&nbsp;</h4>
                                    	<div class="col-lg-12" id='bsection'>
                                    		<label style='display:none' id='budgetstat'>Proposed</label>
                                    		<div id='pbchoices' style='display:none'>
                                    			<button id='addpb' class='btn btn-success'><i class='icon_plus_alt2'></i></button>&nbsp;
                                    			<button id='resetpb' class='btn btn-danger'>Reset</button>&nbsp;
                                    			<button id='basefrom' class='btn btn-warning'>Base from revision</button>
                                    		</div>
                                    		<table class="table table-hover personal-task" id="budgettable" >
                                                <thead>
                                                    <th style="display: none"></th>
	                                                <th style="text-align:center">Budget Item</th>
	                                                <th style="text-align:center">Expense Type</th>
	                                                <th style="text-align:center">Quantity</th>
	                                                <th style="text-align:center">Amount</th>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th style="text-align:right" colspan="3">Grand Total :</th>
                                                        <td id="totalamount"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                    	</div>
                                    	<div class="col-lg-6" id='bsection2' style='display:none;'>

                                            <label>Revision</label>
                                            <button onclick='refreshRevision();' id='resetbudg' class='btn btn-danger'>Reset</button>
                                            <div id='budgetlogs'></div> 
                                            <table class="table table-hover personal-task" id="budgetrevision" >
                                                <thead>
	                                                <th style="text-align:center">Budget Item</th>
	                                                <th style="text-align:center">Expense Type</th>
	                                                <th style="text-align:center">Quantity</th>
	                                                <th style="text-align:center">Amount</th>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th style="text-align:right" colspan="3">Grand Total :</th>
                                                        <td id="totalamount2"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="col-lg-6" id='bsection3' style='display:none;'>
                                            <label>Actual Budget</label>
                                            <table class="table table-hover personal-task" id="actbudget" >
                                                <thead>
	                                                <th style="text-align:center">Budget Item</th>
	                                                <th style="text-align:center">Expense Type</th>
	                                                <th style="text-align:center">Quantity</th>
	                                                <th style="text-align:center">Amount</th>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th style="text-align:right" colspan="3">Grand Total :</th>
                                                        <td id="totalamount3"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div id='budgetrev' style='display:none;' align='right'>
                                            <button class='btn btn-success' id='aggbudget'><i class='icon_check_alt2'></i>&nbsp;Accept Revision</button>
                                            <button class='btn btn-success' id='scrapBudget'><i class='icon_check_alt2'></i>&nbsp;Scrap Project</button>
                                            <button class='btn btn-danger' id='changbudget'><i class='icon_clipboard'></i>&nbsp;Revise Proposal</button>
                                        </div>
                                        <div id='budgetrev2' style='display:none;' align='right'>
                                            <button class='btn btn-success' id='aggbudget2'><i class='icon_check_alt2'></i>&nbsp;Submit Revision</button>
                                            <button class='btn btn-danger' id='changbudget2'><i class='icon_clipboard'></i>&nbsp;Cancel Revision</button>
                                        </div>
                                    </div>
                                    <div id='hiddenbudget2'>
                                        <div class="span12" id="budgetspan"><hr></div>				     
                                        <div class="bio-graph-heading3"> 
                                            <h4 style="text-align:center;">Project Output:&nbsp;<button class='btn btn-success'  id='section6'><i class='icon_plus_alt2'></i></button><button class='btn btn-warning' id='rev6' onclick='addComment(this, 6)' title='Revise'><i class='icon_clipboard'></i></button></h4>
                                            <table class="table table-hover personal-task" id="outputtable" >
                                                <thead>
                                                <th style="display:none"></th>
                                                <th style="text-align:center">Expected Output</th>
                                                <th style="text-align:center">Performance Indicator</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>											
                                        </div>
                                    </div>
                                    <div id="filesdiv">
                                        <div class="bio-graph-heading3"> 
                                            <h4 style="text-align:center;">Project Files:&nbsp;<button class='btn btn-success'  id='uploadButton'><i class='icon_plus_alt2'></i></button></h4>
                                            <table class="table table-hover personal-task" id="filestable" >
                                                <thead>
                                                    <th style="display:none"></th>
                                                    <th style="text-align:center">File Name</th>
                                                    <th style="text-align:center">File Size</th>
                                                    <th style="text-align:center">Uploader</th>
                                                    <th style="text-align:center">Date</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                            	</section>
                            	<section>
                                    <div class="row">   
                                        <div id='budgetbuttons' style='display:none;' align='right'>
                                            <button class='btn btn-success' id='appbudget'><i class='icon_check_alt2'></i>&nbsp;Approve</button>
                                            <button class='btn btn-danger' id='revbudget'><i class='icon_clipboard'></i>&nbsp;Revise</button>
                                        </div>
                                        <div id='budgetbuttons2' style='display:none' align='right'>
                                            <button class='btn btn-success' id='subrev'><i class='icon_check_alt2'></i>&nbsp;Submit Revision</button>
                                            <button class='btn btn-danger' id='cancelrev'><i class='icon_close_alt2'></i>&nbsp;Cancel Revision</button>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div id="edit-profile" class="tab-pane">
                                <button class="btn btn-success" id="backlocation"><i class="icon_compass_alt"></i>&nbsp;Back to Location</button> 
                                &nbsp;<button class='btn btn-warning' id='rev7' onclick='addComment(this, 7)' title='Revise'><i class='icon_clipboard'></i></button>
                                <div id="map-canvas" ></div>  
                            </div>
                            <div id="pexpenses" class="tab-pane">
                                <table id="pexpensest" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <th>Expense</th>
                                    <th>Qty</th>
                                    <th>Total Amount</th>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total Amount:</td>
                                            <td id="tamount"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div id="directorbuttons" align="right" style='display:none'>
            <button class="btn btn-success" id='appProj'><i class='icon_check_alt2'></i>&nbsp;Approve</button>
            <button class="btn btn-warning" id='revProj'><i class='icon_clipboard'></i>&nbsp;Revise</button>
            <button class="btn btn-danger" id='decProj'><i class='icon_close_alt2'></i>&nbsp;Decline</button>
        </div>
        <div id='dirrevbuttons' align='right' style='display:none'>
            <button class="btn btn-success" id='appRev'><i class='icon_check_alt2'></i>&nbsp;Submit Revision</button>
            <button class="btn btn-danger" id='cancRev'><i class='icon_clipboard'></i>&nbsp;Cancel Revision</button>
        </div>
        <div id='dirrevemp' align='right' style='display:none'>
            <button class="btn btn-success" id='appDirRev'><i class='icon_check_alt2'></i>&nbsp;Submit Revision</button>
            <button class="btn btn-danger" id='cancDirRev'><i class='icon_clipboard'></i>&nbsp;Scrap Project</button>
        </div>
	</section>
</section>
<div class="modal fade" id="budgetModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Revise Budget</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Budget Item:</label>                                                                                                           													
                        <div class="input-group">
                            <span id='budgitem'></span>
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Expense Type:</label>                                                                                                           													
                        <div class="input-group">
                            <span id='exptype'></span> 
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form" id='qtybudget'>
                    <div class="form-group">
                        <label>Quantity:</label>                                                                                                           													
                        <div class="input-group">
                            <input type="text" id="budgqty" class="form-control" aria-label="..." placeholder="Qty">														
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label id='revamount'></label>                                                                                                           													
                        <div class="input-group">
                            <input type="text" id="budgamount" class="form-control" aria-label="..." placeholder="Budget Amount">														
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Reason:</label>                                                                                                           													
                        <div class="input-group">
                            <textarea class="form-control" rows="9" cols="73" id="budgreason" style="min-width: 100%;"></textarea>
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
            </div>
            <div class="modal-footer" id='budgbuttons'>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="budgetModal2" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Revise Budget</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Budget Item:</label>                                                                                                           													
                        <div class="input-group">
                            <span id='budgitem2'></span>
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Expense Type:</label>                                                                                                           													
                        <div class="input-group">
                            <span id='exptype2'></span> 
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form" id='qtybudget2'>
                    <div class="form-group">
                        <label>Quantity:</label>                                                                                                           													
                        <div class="input-group">
                            <input type="text" id="budgqty2" class="form-control" aria-label="..." placeholder="Qty">														
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label id='revamount2'></label>                                                                                                           													
                        <div class="input-group">
                            <input type="text" id="budgamount2" class="form-control" aria-label="..." placeholder="Budget Amount">														
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Reason:</label>                                                                                                           													
                        <div class="input-group">
                            <textarea class="form-control" rows="9" cols="73" id="budgreason2" style="min-width: 100%;"></textarea>
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>
            </div>
            <div class="modal-footer" id='modalbuttons'>
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addBudget" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Expenses</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Expense Type:</label>
                    <select id="etype2" onchange="loadautocomplete(this);" class="form-control">
                        <option value="1">General Expense</option>
                        <option value="2">Equipment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Budget Item:</label>
                    <input type="text" id="bitem2" onchange="clearBudget(this);" class="form-control" placeholder="Item">

                </div>
                <div class="form-group" id="qtygroup" style="display:none;">
                    <label>Qty:</label>
                    <input type="text" id="qty2" onchange="checkValue(this)" class="form-control" placeholder="Qty">
                </div>
                <div class="form-group" id="amountgroup" style="display:none;">
                    <label>Amount:</label>
                    <input type="text" id="amount2" class="form-control" placeholder="Amount">
                </div>
                <div class="form-group">
                    <label>Reason:</label>
                    <textarea class="form-control" rows="9" cols="73" id="reason2" style="min-width: 100%;"></textarea>
                </div>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group" id="btnbudget">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="closeProject" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Closing of Project</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Reason:</label>
                    <textarea class="form-control" rows="9" cols="73" id="projreason" style="min-width: 100%;"></textarea>
                </div>
                <br>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-primary' id='subreason'>Close Project</button>
                <button class='btn btn-default'  data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="revComment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Revision Comments</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Comment:</label>
                    <div id="revCommentDiv"></div>
                </div>
                <br>
            </div>
            <div class='modal-footer'>
                <span id='commentbutton'></span>
                <button class='btn btn-default'  data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="changeProject" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title" id='projheader'></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label id='proj'></label>
                    <textarea  class="form-control" rows="9" cols="73" id="projcom" style="min-width: 100%;"></textarea>
                </div>
                <br>
            </div>
            <div class='modal-footer'>
                <span id='projbutton'></span>
                <button class='btn btn-default'  data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" id="specialBudget" class="modal fade">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id='equipment'></h4>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-sm-6" align='left'>
                        <p>Qty that can be provided:</p>
                        <p>Amount:</p>
                        <p>Qty need to be bought:</p>
                        <p>Amount per equipment:</p>
                        <p>Reason:</p>
                        <textarea class="form-control" rows="9" cols="73" id="qreason" style="min-width: 100%;"></textarea>
                    </div>
                    <div class="col-sm-6" align='left'>
                        <p id='qhave'></p>
                        <p id='qamount'></p>
                        <p id='qbuy' ></p>
                        <input type='text'  id='amountbuy'>
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-success' id='addSpecical'>Add</button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addObjective" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Objective</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" class="form-control"  id='objective' placeholder="This Project aims to..">
                            <span class="input-group-btn" id="btns">
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addOutput" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Project Output</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Expected Output:</label>
                        <input type="text" id="eoutput" class="form-control" placeholder="">
                    </div>
                    <br><br>
                    <div class="form-group">
                        <label>Performance indicator</label>
                        <textarea class="form-control" rows="9" cols="70" id="pindicator" style="min-width: 100%;"></textarea>
                    </div>
                </form> 
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group" id="btnoutputs">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="taskDetails" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title" id="taskname"></h4>     
            </div>
            <div class="modal-body">
                <h4>Progress:</h4>
                <div class="progress">
                    <span class="progress-value" id='pbar2'></span>
                    <div class="progress-bar" id='pbar'>
                    </div>
                </div>
                <br>
                <h4>Subtasks</h4>
                <table class="table table-advance table-hover" id="tasksub" style="text-align:center">
                    <thead>
	                    <th style="text-align:center"><i class="icon_lightbulb_alt"></i>&nbsp;Subtask</th>
	                    <th style="text-align:center"><i class="icon_percent_alt"></i>&nbsp;Percent</th> 
	                    <th style="text-align:center"><i class="icon_comment_alt"></i>&nbsp;Status</th> 
	                    <th style="text-align:center"><i class="icon_cogs"></i>&nbsp;Actions</th> 
                    </thead>
                    <tbody></tbody>
                </table>
                <h4>Required Skillsets:</h4>
                <h4> <label class='label label-primary' id="tskillsets"></label></h4>
                <h4>Equipments Assigned</h4>
                <table class="table  table-advance table-hover" id="empeqtable" style="text-align:center">
                    <thead>
	                    <th style="text-align:center"><i class='icon_cart_alt'></i>&nbsp;Equipment Name</th>
	                    <th style="text-align:center"><i class='icon_calculator_alt'></i>&nbsp;Qty</th>
	                    <th style="text-align:center"><i class='icon_box-checked'></i>&nbsp;Used</th>
                    </thead>
                    <tbody></tbody>
                </table>
                <h4>Employees Involved</h4>
                <table class="table  table-advance table-hover" id="emptakstable" style="text-align:center">
                    <thead>
	                    <th style="text-align:center"><i class='icon_profile'></i>&nbsp;Employee Name</th>
	                    <th style="text-align:center"><i class='icon_comment_alt'></i>&nbsp;Status</th>
                    </thead>
                    <tbody></tbody>
                </table>
                <br>
                <div id="btnoutputs2" align="right">
                </div>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="decreason" 
     class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" id="cclose" class="close" type="button">×</button>
                <h4 class="modal-title">Reason</h4>
            </div>
            <div class="modal-body">
                <textarea id="rreason" class="form-control"></textarea>
                <button  style='margin-top:10px;' class="btn btn-success btn-sm" id='dsave'><i class='icon_floppy_alt'></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="vemployees" 
     class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" id="cclose2" class="close"  type="button">×</button>
                <h4 class="modal-title">Choose Employees</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Worked in Philvocs:&nbsp;<a href='javascript:void(0)' id='resBut2'><label class='label label-default' onmouseover="changeBackground(this);">Reset</label></a></label>
                        <br>
                        <div>
                            <div class='col-sm-4'>   
                                <select id='dcond' class='form-control dd'>
                                    <option value='='>For</option>
                                    <option value='>'>More than</option>
                                    <option value='<'>Less Than</option>
                                    <option value='>='>At Least</option>
                                    <option value='<='>At Most</option>

                                </select></div>
                            <div class='col-sm-3'>   
                                <input type='number'  min='1' id='dcond2' style='text-align:center;'  class='form-control dd'>
                            </div>
                            <div class='col-sm-4'>   
	                            <select id='dcond3' class='form-control dd'>
	                                <option value='month'>month/s</option>
	                                <option value='year'>year/s</option>
	                            </select>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Has been a project head:</label>
                        <div class="input-group">
                            Yes&nbsp;<input type="checkbox" name='cbox2' onchange='checkk(this);' value="1">&nbsp;No&nbsp;<input onchange='checkk(this);' type="checkbox" name='cbox2' value="2">
                        </div>
                    </div>
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Involved in tasks with the ff: priority levels:</label>
                        <select multiple class="form-control m-bot15"   style="width:510px;" data-placeholder='Choose Priority Levels' id="plevelemp">
                            <option value='1'>Low</option>
                            <option value='2'>Medium</option>
                            <option value='3'>High</option>
                            <option value='4'>Emergency</option>
                        </select>
                    </div>  
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <a class="btn btn-success pull-right" style="margin-top:10px;" id="searchEmployee">Search</a>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="decreason2" 
     class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Reason</h4>
            </div>
            <div class="modal-body">
                <textarea id="rreason2" class="form-control"></textarea>
                <button  style='margin-top:10px;' class="btn btn-success btn-sm" id='dsave2'><i class='icon_floppy_alt'></i>&nbsp;Save</button>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="workplan" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Work Plan</h4>
            </div>
            <div class="modal-body">
                <label class="alert alert-danger" id="addtaskalert" style="width:100%;display:none;text-align:center">HELLO</label>

                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Activity Name:</label>                                                                                                           													
                        <div class="input-group">
                            <input type="text" id="aname" class="form-control" aria-label="..." placeholder="Activity">														
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>	 
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Duration From:</label>
                        <input type="text" class="form-control" aria-label="..." placeholder="From" id="taskfrom">
                    </div>
                    <div class="form-group">
                        <label>To:</label>
                        <input type="text" class="form-control" aria-label="..." placeholder="To" id="taskto">
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <label>Will be Involved: </label>
                    <select id="inv" class="form-control">
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Priority</label>
                        <select id="taskpriority" class="form-control">
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>
                            <option value="4">Emergency</option>
                        </select>
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Total Employees Needed:</label>
                        <input type="number" class="form-control" value="1" min="1" id="numemp">
                    </div>
                </form><br>
                <div class="form-group" id="taskskillz">
                    <label>Required Skillsets:</label>
                    <select data-placeholder="Filter Tags"   style="width:510px;" id="workskills" multiple class="chosen-select a" tabindex="8">
                    </select>
                </div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Milestone Indicator:</label>
                        <textarea class="form-control" rows="9" cols="73" id="milestone" style="min-width: 100%;"></textarea>
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Output:</label>
                        <textarea class="form-control" rows="9" cols="73" id="outputs" style="min-width: 100%;"></textarea>
                    </div>
                </form>
                <form class="form-inline" role="form">
                    <div class="form-group" id="workplanbtns">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel"  data-keyboard="false"  id="modallist" role="dialog" tabindex="-1" id="
     " class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true"  class="close" id="cclose4" type="button">×</button>
                <h4 class="modal-title">Employee List</h4>
            </div>
            <div class="modal-body" id="pheadlist" style="max-height: 500px;overflow-y: scroll;">
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel"  data-keyboard="false"  id="vreasons" role="dialog" tabindex="-1" id="
     " class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true"  class="close" id="cclose3" type="button">×</button>
                <h4 class="modal-title">Reason For declining</h4>
            </div>
            <div class="modal-body" id="rdecline" style="max-height: 500px;overflow-y: scroll;">
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="headModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Project Head Filters</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Worked in Philvocs:&nbsp;<a href='javascript:void(0)' id='resBut'><label class='label label-default' onmouseover="changeBackground(this);">Reset</label></a></label>
                        <br>
                        <div>
                            <div class='col-sm-4'>   
                                <select id='condition' class='form-control'>
                                    <option value='='>For</option>
                                    <option value='>'>More than</option>
                                    <option value='<'>Less Than</option>
                                    <option value='>='>At Least</option>
                                    <option value='<='>At Most</option>
                                </select></div>
                            <div class='col-sm-3'>   
                                <input type='number'  min='1' id='numfilter' style='text-align:center;'  class='form-control'>
                            </div><div class='col-sm-4'>   
                                <select id='condition2' class='form-control'>
                                    <option value='month'>month/s</option>
                                    <option value='year'>year/s</option>
                                </select></div>
                        </div>
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Has been a project head:</label>
                        <div class="input-group">
                            Yes&nbsp;<input type="checkbox" name='cbox' onchange='check(this);' value="1">&nbsp;No&nbsp;<input onchange='check(this);' type="checkbox" name='cbox' value="2">

                        </div>
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Has the Skillset:</label>                                                                                                           													
                        <div class="input-group">
                            <select data-placeholder="Skillsets" onchange="addFilter(this)" id="skillsets" style="width:150px;" class="chosen-select" tabindex="7">
                            </select>
                        </div><!-- /input-group -->   
                    </div>                                               
                </form>	 
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Handled/Part of Projects with Priority Level:</label>
                        <select class="form-control m-bot15" onchange="addFilter(this)" id="plevel">
                            <option value="priority:1">Low</option>
                            <option value="priority:2">Medium</option>
                            <option value="priority:3">High</option>
                        </select>
                    </div>  
                </form>
                <form class="form-inline" role="form" id="filterform">
                    <div class="form-group">
                        <label>Filter List:</label>
                        <select data-placeholder="Filter Tags"   style="width:510px;" id="filters" multiple class="chosen-select a" tabindex="8">
                        </select>
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <a class="btn btn-success pull-right" id="projectsearch">Search</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="sModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" id="ccz4" class="close" type="button">×</button>
                <h4 class="modal-title" id="stitle"></h4>
            </div>
            <div class="modal-body">

                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Date Finished:</label><br>
                        <p id="dfinished"></p>
                    </div>
                </form><br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Contribution:</label><br>
                        <p id="conts"></p>
                    </div>
                </form>
                <br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label>Employee Involved:</label><br>
                        <p id="einvolved"></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="aprojModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Add Expense</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td>Expense</td>
                        <td><input type="text" id="expense"></td>
                    </tr>
                    <tr>
                        <td>Qty</td>
                        <td><input type="text" id="qty"></td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td><input type="text" id="amount"></td>
                    </tr>
                </table>
                <button class="btn btn-success" id="aexp">Add Expense</button>
            </div>
        </div>
    </div>
</div>