<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/13/2016
 * Time: 7:02 PM
 */

$ci = &get_instance();
$ci->config->set_item('base_url',"http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/") ;
?>

<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/elegant-icons-style.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/style-responsive.css" rel="stylesheet" />
<link href='<?=base_url()?>assets/js/libraries/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='<?=base_url()?>assets/js/libraries/fullcalendar/eventdot.css' rel='stylesheet' />
<link href='<?=base_url()?>assets/js/libraries/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?=base_url()?>assets/css/jquery.ui.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/elegant-icons-style.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/style2.css" rel="stylesheet">'
<link href="<?=base_url()?>assets/css/lightbox.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/style-responsive.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/js/libraries/chosen/chosen.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/owl.carousel.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>assets/css/tooltipster.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/css/jquery.minicolors.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>assets/js/libraries/gantt/jquery.ganttView.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/js/libraries/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" >
<link href="<?=base_url()?>assets/js/libraries/fileupload/dist/bootstrap.fd.css" rel="stylesheet">

<script src="<?=base_url()?>/assets/js/libraries/js/jquery-1.10.2.js"></script>
<!--<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>-->
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.form.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.minicolors.min.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.tooltipster.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/lightbox.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/lightbox.min.map" type="text/plain"></script>
<!--<script src="<?=base_url()?>/assets/js/libraries/fullcalendar/fullcalendar.min.js"></script>-->
<script src="<?=base_url()?>/assets/js/libraries/gantt/date.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/gantt/jquery.ganttView.js" type="text/javascript"></script>
<!--<script src="<?=base_url()?>/assets/js/libraries/js/bootstrap-switch.js"></script>-->
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.scrollTo.min.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/ga.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.tagsinput.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.hotkeys.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/bootstrap-wysiwyg.js"></script>
<!--<script src="<?=base_url()?>/assets/js/libraries/js/bootstrap-wysiwyg-custom.js"></script>-->
<script src="<?=base_url()?>/assets/js/libraries/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/jquery-knob/js/jquery.knob.js"></script>	
<script src='<?=base_url()?>/assets/js/libraries/fullcalendar/lib/moment.min.js'></script>
<!--<script src="<?=base_url()?>/assets/js/libraries/fullcalendar/lib/jquery.min.js"></script>-->
<!--<script src="<?=base_url()?>/assets/js/libraries/fullcalendar/lib/jquery-ui.custom.min.js"></script>-->
<script src='<?=base_url()?>/assets/js/libraries/fullcalendar/fullcalendar.min.js'></script>
<script src='<?=base_url()?>/assets/js/libraries/fullcalendar/fullcalendar.js'></script>
<!--<script src="<?=base_url()?>/assets/js/libraries/js/scripts.js"></script>-->
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/owl.carousel.js" ></script>
<script src="<?=base_url()?>/assets/js/libraries/js/calendar-custom.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/jquery.customSelect.min.js" ></script>
<script src="<?=base_url()?>/assets/js/libraries/js/sparkline-chart.js"></script>
<script src="<?=base_url()?>/assets/HelperFunctions.js"></script>
<!--<script src='<?=base_url()?>/assets/js/libraries/js/easy-pie-chart.js'></script>-->
<script src="<?=base_url()?>/assets/js/libraries/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/sweetalert/sweetalert.min.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/js/tinysort.min.js"></script>
<script src="<?=base_url()?>/assets/js/libraries/fileupload/src/bootstrap.fd.js"></script>

<!--<script src='<?=base_url()?>/assets/js/libraries/jqueryPrintElement/jquery.printElement.js'></script>-->
<script src='<?=base_url()?>/assets/js/libraries/printThis/printThis.js'></script>
<script src="http://maps.googleapis.com/maps/api/js"></script>

<div class="modal fade" tabindex="-1" role="dialog" id="loading" data-backdrop="static" data-keyboard="false">
    <div style="display: inline-block;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 200px;
            height: 100px;
            margin: auto;"><image src="<?=base_url()?>/assets/images/loading.gif"></div>
</div>