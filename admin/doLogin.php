<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-19
 * Time: 下午3:52
 */
require_once '../include.php';

//session_start();
$username=$_POST['username'];
$password=md5($_POST['password']);
$verify=$_POST['verify']; // entered by the user
$verify1=$_SESSION['verify']; // generated by the backstage
if(isset($_POST['autoFlag'])){
    $autoFlag=$_POST['autoFlag'];
}

//$autoFlag=$_POST['autoFlag'];
if($verify==$verify1){
    $sql="select * from biogas_admin where username='{$username}' and password='{$password}'";
    $row=checkAdmin($sql);
    if($row){
        // If selected auto login
        if($autoFlag){
            setcookie("adminId",$row['id'],time()+7*24*3600);
            setcookie("adminName",$row['username'], time()+7*24*3600);
        }
        $_SESSION['adminName']=$row['username'];
        $_SESSION['adminId']=$row['id'];
        header("location:index.php");
    }else{
        alertMes("登录失败, 重新登录!", "login.php");
    }
}else{
    alertMes("验证码错误!", "login.php");
}