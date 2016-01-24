<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/19/2016
 * Time: 7:39 PM
 */
require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript);  ?>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <section class="panel">
                            <header class="panel-heading">
                                Skillsets
                                <button class="btn btn-info pull-right"  style="margin-top: -7px; margin-right: 9px;margin-bottom:-10px;" type="button" id='skillbutton'><i class="icon_plus_alt2"></i> Add Skillset</button>
                            </header>
                            <label class='alert alert-danger' id='skillalert' style='width:100%;text-align:center;display:none'>No Skillset Found.</label>

                            <div id='skillsets' style='display:none'>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <section class="panel">
                            <header class="panel-heading">
                                Employees
                                <button class="btn btn-info pull-right"  style="margin-top: -7px; margin-right: 9px;margin-bottom:-10px;" id='empButton'><i class="icon_plus_alt2"></i> Add Employee</button>
                            </header>
                            <label class='alert alert-danger' id='employeealert' style='width:100%;text-align:center;display:none'></label>
                            <div id='employee' style='display:none;'>
                                <br>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="employeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                <h4 class="modal-title" id='employeetitle'>Add Employee</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <label class='alert alert-danger' id='emodalalert' style='display:none;width:100%;text-align:center'></label>
                    <label>First Name</label>
                    <input type="text" id="fname" class="form-control">
                    <label>Middle Initial</label>
                    <input type="text" id="mi" class="form-control">
                    <label>Last Name</label>
                    <input type="text" id="lname" class="form-control">
                    <label>Email</label>
                    <input type="text" id="email" class="form-control" placeholder='e.g. example@example.com'>
                    <?php if($_SESSION['position'] == 1){?>
                    <label>Division</label>
                    <select  id="did" onchange='changeDrop(this)'  class='form-control'>
                        <option value='1'>Volcanology</option>
                        <option value='2'>Seismology</option>
                        <option value='3'>Finance and admin</option>
                        <option value='4'>Research and development</option>
                        <option value='5'>Disaster preparedness</option>
                    </select>
                    <label>Position</label>
                    <select  id="pid"  class='form-control'>
                        <option value='2'>Division Chief</option>
                        <option value='3'>Project Member</option>
                    </select>
                    <?php }?>
                    <label>Skillsets</label><br>
                    <div id='sfilters'></div>
                    <label>Max Load</label>
                    <input type="text" id="mload" class="form-control" value="30">
                </div>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-info btn-block" id='saveEmployee'>Save</button>
            </div>

        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="skillsModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                <h4 class="modal-title" id='skilltitle'>Add Skillset</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <label class='alert alert-danger' id='smodalalert' style='display:none;width:100%;text-align:center'>Skillset already exists</label>
                    <label>Name</label>
                    <input type="text" class="form-control" id='sname'>
                    <label>Description</label><br>
                    <textarea class="form-control" id='sdesc' rows="5" style="min-width: 100%" cols="60"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-info btn-block" id='saveSkillSet'>Save</button>
            </div>
        </div>
    </div>
</div>

