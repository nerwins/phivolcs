<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/13/2016
 * Time: 6:55 PM
 */?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Log In</title>
    <?php require_once("assets/includes.php");
    require_once($page_javascript);  ?>
</head>
<body class="login-img3-body">

<div class="container">
    <div class="login-wrap login-form">
        <p class="login-img"> PHI<span></span><span class="lite">VOLCS</span></p>
        <label class="alert alert-danger" id='erroralert' style="width:100%;text-align:center;display:none">Invalid Username or Password</label>
        <label class="alert alert-info" id='connectingalert' style="width:100%;text-align:center;display:none">Connecting...</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_profile"></i></span>
            <input type="text" class="form-control" placeholder="Username" id='username' autofocus>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_key_alt"></i></span>
            <input type="password" class="form-control" id='pass' placeholder="Password">
        </div>
        <button class="btn btn-primary btn-lg btn-block" id='login'>Login</button>
    </div>
</div>
</body>
</html>
