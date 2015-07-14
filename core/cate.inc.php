<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-30
 * Time: 下午8:18
 */

/*
 * Add cate
 * */
function addCate(){
    $arr=$_POST;
    if(insert("imooc_cate",$arr)){
        $mes="Add successfully!<br/><a href='addCate.php'>Go on adding!</a>|<a href='listCate.php'>Look up the list!</a>";
    }else{
        $mes="Failed to add!<br/><a href='addCate.php'>Try again!</a>|<a href='listCate.php'>Look up the list!</a>";
    }
    return $mes;
}
/*
 * Get info according to the id
 * */
function getCateById($id){
    $sql="select id,cName from imooc_cate where id={$id}";
    return fetchOne($sql);
}

/*
 * Edit cate
 * */
function editCate($where){
    $arr=$_POST;
    if(update("imooc_cate",$arr,$where)){
        $mes="Successfully modified!<br/><a href='listCate.php'>Look up the list!</a>";
    }else{
        $mes="Modification failed!<br/><a href='listCate.php'>Try again!</a>";
    }
    return $mes;
}

/*
 * Delete cate
 * */
function delCate($where){
    if(delete("imooc_cate",$where)){
        $mes="Delete Successfully!<br/><a href='listCate.php'>Look up the list!</a>|<a href='addCate.php'>Add cate!</a>";
    }else{
        $mes="Delete Failed!<br/><a href='listCate.php'>Try again!</a>";
    }
    return $mes;
}

//function getAllCateByPage(){
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