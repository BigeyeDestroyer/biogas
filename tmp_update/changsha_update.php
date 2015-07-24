<?php
require_once '../include.php';
$res = getItem('长沙');
$res_insert = array();
$res_insert['date'] = $res['date'];
$res_insert['l_tmp'] = $res['l_tmp'];
$res_insert['h_tmp'] = $res['h_tmp'];
insert($res['pinyin']."_tmp", $res_insert);