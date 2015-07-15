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
    if(insert("biogas_prov",$arr)){
        $mes="添加成功!<br/><a href='addCate.php'>继续添加!</a>|<a href='listCate.php'>查看列表!</a>";
    }else{
        $mes="添加失败!<br/><a href='addCate.php'>重新添加!</a>|<a href='listCate.php'>查看列表!</a>";
    }
    return $mes;
}
/*
 * Get info according to the id
 * */
function getCateById($id){
    $sql="select id,province from biogas_prov where id={$id}";
    return fetchOne($sql);
}

/*
 * Edit cate
 * */
function editCate($where){
    $arr=$_POST;
    if(update("biogas_prov",$arr,$where)){
        $mes="修改成功!<br/><a href='listCate.php'>查看列表!</a>";
    }else{
        $mes="修改失败!<br/><a href='listCate.php'>重新修改!</a>";
    }
    return $mes;
}

/*
 * Delete cate
 * */
function delCate($where){
    if(delete("biogas_prov",$where)){
        $mes="删除成功!<br/><a href='listCate.php'>查看列表!</a>|<a href='addCate.php'>添加省份!</a>";
    }else{
        $mes="删除失败!<br/><a href='listCate.php'>重新删除!</a>";
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