<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 7/23/15
 * Time: 4:23 PM
 */

require_once '../include.php';

$sql = "select pinyin from biogas_city where id=2";
$cName = fetchOne($sql)['pinyin'];
dropTable($cName);
