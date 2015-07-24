<?php
require_once '../include.php';

/*
 * Check if there is admin
 * */
function checkAdmin($sql){
    return fetchOne($sql);
}

/*
 * Check whether the admin has logined
 * */
function checkLogined(){
//    if((!isset($_SESSION['adminId']))){
//        alertMes("Login first!", "login.php");
//    }
    // To check whether _SESSION or _COOKIE has been defined
    if((!isset($_SESSION['adminId']))&&(!isset($_COOKIE['adminId']))){
        alertMes("请先登录!", "login.php");
    }
    if(@$_SESSION['adminId']==""&&$_COOKIE['adminId']==""){
        alertMes("请先登录!", "login.php");
    }
}


function addAdmin(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if(insert("biogas_admin",$arr)){
        $mes="添加成功!<br/><a href='addAdmin.php'>继续添加!</a>|<a href='listAdmin.php'>返回列表</a>";
    }else{
        $mes="添加失败!<br/><a href='addAdmin.php'>继续添加!</a>";
    }
    return $mes;
}
/*
 * Get all the admin
 * */
function getAllAdmin(){

    $sql="select id,username,email from biogas_admin";
    $rows=fetchAll($sql);
    return $rows;
}

//function getAdminByPage($page,$pageSize=2){
//    $sql="select * from imooc_admin";
//    $totalRows=getResultNum($sql);
//    global $totalPage;
//    $totalPage=ceil($totalRows/$pageSize);
//    //$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
//    if($page<1||$page==null||!is_numeric($page)){
//        $page=1;
//    }
//    if($page>=$totalPage){
//        $page=$totalPage;
//    }
//    $offset=($page-1)*$pageSize;
//    $sql="select id,username,email from imooc_admin limit {$offset},{$pageSize}";
//    $rows=fetchAll($sql);
//    return $rows;
//}

/*
 * Edit the admin
 * */
function editAdmin($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if(update("biogas_admin",$arr,"id={$id}")){
        $mes="编辑成功!<br/><a href='listAdmin.php'>查看列表!</a>";
    }else{
        $mes="编辑失败!<br/><a href='listAdmin.php'>重新编辑!</a>";
    }
    return $mes;
}

/*
 * Delete admin
 * */
function delAdmin($id){
    if(delete("biogas_admin","id={$id}")){
        $mes="删除成功!<br/><a href='listAdmin.php'>查看列表!</a>";
    }else{
        $mes="删除失败!<br/><a href='listAdmin.php'>重新删除!</a>";
    }
    return $mes;
}

/*
 *  Admin log out
 * */
function logout(){
    $_SESSION=array();
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),"",time()-1);
    }
    if(isset($_COOKIE['adminId'])){
        setcookie("adminId","",time()-1);
    }
    if(isset($_COOKIE['adminName'])){
        setcookie("adminName","",time()-1);
    }
    session_destroy();
    header("location:login.php");
}

