<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-18
 * Time: 下午10:41
 */

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






































