<?php
require_once '../include.php';
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-29
 * Time: 上午10:16
 */

$act=$_REQUEST['act'];
if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
}

if($act=="logout"){
    logout();
}elseif($act=="addAdmin"){
    $mes=addAdmin();
}elseif($act=="editAdmin"){
    $mes=editAdmin($id);
}elseif($act=="delAdmin"){
    $mes=delAdmin($id);
}elseif($act=="addProv"){
    $mes=addProv();
}elseif($act=="editProv"){
    $where="id={$id}";
    $mes=editProv($where);
}elseif($act=="delProv"){
    $where="id={$id}";
    $mes=delProv($where);
}elseif($act=="addCity"){
    $mes=addCity();
}elseif($act=="editCity"){
    $where="id={$id}";
    $mes=editCity($where);
}elseif($act=="delCity"){
    $where="id={$id}";
    $mes=delCity($where);
}elseif($act=="addUser"){
    $mes=addUser();
}elseif($act=="editUser"){
    $mes=editUser($id);
}elseif($act=="delUser"){
    $mes=delUser($id);
}elseif($act=="queryUser")
    $mes=queryUser($id);
    //$mes=queryTry($id);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<?php
if($mes){
    echo $mes;
}
?>
</body>
</html>