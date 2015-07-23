<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-18
 * Time: 下午10:41
 */
//error_reporting(E_ALL&~E_NOTICE&~E_WARNING); // !!! shutdown the reporting of notices and warnings!!!
/**
Connect database
 */
function connect(){
    $link=mysql_connect(DB_HOST,DB_USER,DB_PWD) or die("Failed to connect sql:".mysql_errno().":".mysql_error());
    mysql_set_charset(DB_CHARSET);
    mysql_select_db(DB_DBNAME) or die("Failed to open the database");
    return $link;
}

/**
Insert info
 */
function insert($table, $array){
    $keys=join(",",array_keys($array));
    $vals="'".join("','",array_values($array))."'";
    $sql="insert {$table}($keys) values({$vals})";
    mysql_query($sql);
    return mysql_insert_id();
}
/*
 * Update info
 * */
// update imooc_admin set username='king' where id=1
function update($table,$array,$where=null){
    $str=null;
    foreach($array as $key=>$val){
        if($str==null){
//        if(!isset($str)){
            $sep="";
        }else{
            $sep=",";
        }
        $str.=$sep.$key."='".$val."'";
    }
    $sql="update {$table} set {$str} ".($where==null?null:" where ".$where);
    $result=mysql_query($sql);
//    var_dump($result);
//    var_dump(mysql_affected_rows());exit;
    if($result){
        return mysql_affected_rows();
    }else{
        return false;
    }
}

/*
 * Delete info
 * */
function delete($table, $where=null){
    $where=$where==null?null:" where ".$where;
    $sql="delete from {$table} {$where}";
    mysql_query($sql);
    return mysql_affected_rows();
}

/*
 * Fetch one item
 * */
function fetchOne($sql, $result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result, $result_type);
    return $row;
}

/*
 * Fetch all items
 * */
function fetchAll($sql, $result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    $rows = array();
    while(@$row=mysql_fetch_array($result, $result_type)){
        $rows[]=$row;
    }
    return $rows;
}


/*
 * Get number of items
 * */
function getResultNum($sql){
    $result=mysql_query($sql);
    return mysql_num_rows($result);
}

/**
 * 得到上一步插入记录的ID号
 * @return number
 */
function getInsertId(){
    return mysql_insert_id();
}

/* 针对 city 创建相应的 temperature 数据表 */
function createTable($cityName){
    $sql = "CREATE TABLE `".$cityName."_tmp` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `l_tmp` decimal(10, 2) NOT NULL,
  `h_tmp` decimal(10, 2) NOT NULL,
  PRIMARY KEY `date`(`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    mysql_query($sql);
}

function dropTable($cityName){
    $sql = "drop table ".$cityName."_tmp;";

    mysql_query($sql);
}




































