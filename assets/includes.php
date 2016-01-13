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
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
