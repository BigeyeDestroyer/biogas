<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-30
 * Time: 下午8:18
 */

/*
 * Add prov
 * */
function addProv(){
    $arr=$_POST;
    if(insert("biogas_prov",$arr)){
        $mes="添加成功!<br/><a href='addProv.php'>继续添加!</a>|<a href='listProv.php'>查看列表!</a>";
    }else{
        $mes="添加失败!<br/><a href='addProv.php'>重新添加!</a>|<a href='listProv.php'>查看列表!</a>";
    }
    return $mes;
}
/*
 * Get info according to the id
 * */
function getProvById($id){
    $sql="select id,province from biogas_prov where id={$id}";
    return fetchOne($sql);
}

/*
 * Edit cate
 * */
function editProv($where){
    $arr=$_POST;
    if(update("biogas_prov",$arr,$where)){
        $mes="修改成功!<br/><a href='listProv.php'>查看列表!</a>";
    }else{
        $mes="修改失败!<br/><a href='listProv.php'>重新修改!</a>";
    }
    return $mes;
}

/*
 * Delete cate
 * */
function delProv($where){
    if(delete("biogas_prov",$where)){
        $mes="删除成功!<br/><a href='listProv.php'>查看列表!</a>|<a href='addProv.php'>添加省份!</a>";
    }else{
        $mes="删除失败!<br/><a href='listProv.php'>重新删除!</a>";
    }
    return $mes;
}

/**
 * 得到所有分类
 * @return array
 */
function getAllProv(){
    $sql="select id,province from biogas_prov";
    $rows=fetchAll($sql);
    return $rows;
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