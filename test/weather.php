<?php
require_once '../include.php';
$sql = "select city from biogas_city where id=2";
$city = fetchOne($sql)['city'];
$res = getTemp($city);
print_r($res);
?>