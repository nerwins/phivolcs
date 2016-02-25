<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:40 PM
 */
require_once("assets/includes.php");
require_once("assets/sidebar.php");
require_once($page_javascript);?>
?>

<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <section class="panel">
                        <header class="panel-heading">
                            Project Nature


                            <button class="btn btn-info pull-right" 
                                    style="margin-top: -7px; margin-right: 9px;margin-bottom:-10px;"
                                    type="button" id='pbutton' onclick="addNature();"><i class="icon_plus_alt2"></i> Add Project Nature</button>

                        </header>
                        <table id="pnaturetable" class="table table-bordered table-striped table-hover">
                            <thead>
                            <th>Project Nature</th>
                            <th>Description</th>
                            <th>Actions</th>
                            </thead>
                            <tbody></tbody>



                        </table>

                    </section>

                </div>
            </div>
        </div>
    </section>
</section>

<div class="modal fade" id="dataModal" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" 
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id='etitle'>

                </h4>
            </div>
            <div class="modal-body">
                <!--Add some text here-->
                <label class='alert alert-danger' id='modalAlert' style='display:none;text-align:center;width:100%'>
                    <a class='close' onclick="closeAlert();">&times;</a>
                    <span id='alertMessage'></span>
                </label>
                <div class="modal-body" id='addmodalbody'>

                    <center>
                        <table>
                            <tbody>

                                <tr>
                                    <td><strong>Name:&nbsp;</strong></td>
                                    <td><input type='text' id='name' class='form-control'></td>
                                </tr>
                                <tr>
                                    <td><strong>Description:&nbsp;</strong></td>
                                    <td><textarea id='description' class='form-control'></textarea></td>
                                </tr>
                                <tr>
                                    <td><strong>Skillset:&nbsp;</strong></td>
                                    <td><!--<div class="input-group">
			                            <select data-placeholder="Skillsets" onchange="addFilter(this)" id="skillsets" style="width:150px;" class="chosen-select" tabindex="7">
			                            </select>
			                        </div>-->
			                        <div id='sfilters'></div>
			                    	</td>
                                </tr>

                            </tbody>
                        </table>
                    </center>
                </div>
            </div>
            <div class="modal-footer">
                <button class='btn btn-danger pull-left btn-small' data-dismiss='modal'>&nbsp;Close</button>
                <button class='btn btn-success pull-right btn-small' id='save' onclick="saveNature();">&nbsp;Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>