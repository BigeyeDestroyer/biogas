<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-30
 * Time: 下午8:18
 */

/*
 * Add city
 * */
require_once '../include.php';

function addCity(){
    $arr=$_POST;
    $city_get = getTemp($arr['city']);
    $city_info['city'] = $arr['city'];
    $city_info['pinyin'] = $city_get['pinyin'];
    $city_info['pubDate'] = $city_get['date'];
    $city_info['longitude'] = $city_get['longitude'];
    $city_info['latitude'] = $city_get['latitude'];
    $city_info['altitude'] = $city_get['altitude'];

    $cName = $city_info['city'];
    $pinyin = $city_info['pinyin'];

    $str = "<?php"."\r\n"."require_once '../lib/mysql.func.php';\r\n"
        ."require_once '../lib/temp.func.php';\r\n"
        ."\r\n"
        ."mysql_connect(\"localhost:/tmp/mysql.sock\",\"root\",\"\");\r\n"
        ."mysql_set_charset(\"utf8\");\r\n"
        ."mysql_select_db(\"biogas\");\r\n"
        ."\r\n"
        ."\$res = getItem('".$cName."');\r\n"."\$res_insert = array();\r\n"
        ."\$res_insert['date'] = \$res['date'];\r\n"
        ."\$res_insert['l_tmp'] = \$res['l_tmp'];\r\n"
        ."\$res_insert['h_tmp'] = \$res['h_tmp'];\r\n"
        ."insert(\$res['pinyin'].\"_tmp\", \$res_insert);";

    $filename = '../tmp_update/'.$pinyin.'_update.php';


    if(insert("biogas_city",$city_info)){
        createTable($city_info['pinyin']); //(1) 创建城市温度表

        file_put_contents($filename,$str); //(2) 创建温度更新脚本
        chmod($filename, 0777);
        $mes="添加成功!<br/><a href='addCity.php'>继续添加!</a>|<a href='listCity.php'>查看列表!</a>";
    }else{
        $mes="添加失败!<br/><a href='addCity.php'>重新添加!</a>|<a href='listCity.php'>查看列表!</a>";
    }
    return $mes;
}
/*
 * Get info according to the id
 * */
function getCityById($id){
    $sql="select id,city from biogas_city where id={$id}";
    return fetchOne($sql);
}

/*
 * Edit cate
 * */
function editCity($where){
    $arr=$_POST;
    if(update("biogas_city",$arr,$where)){
        $mes="修改成功!<br/><a href='listCity.php'>查看列表!</a>";
    }else{
        $mes="修改失败!<br/><a href='listCity.php'>重新修改!</a>";
    }
    return $mes;
}

/*
 * Delete cate
 * */
function delCity($where){
    $sql = "select pinyin from biogas_city where ".$where;
    $cName = fetchOne($sql)['pinyin'];
    if(delete("biogas_city",$where)){
        dropTable($cName); //(1)同时删除城市对应的数据表
        unlink("../tmp_update/".$cName."_update.php"); //(2)删除对应的脚本文件
        $mes="删除成功!<br/><a href='listCity.php'>查看列表!</a>|<a href='addCity.php'>添加城市!</a>";
    }else{
        $mes="删除失败!<br/><a href='listCity.php'>重新删除!</a>";
    }
    return $mes;
}

/**
 * 得到所有城市
 * @return array
 */
function getAllCity(){
    $sql="select id,city from biogas_city";
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