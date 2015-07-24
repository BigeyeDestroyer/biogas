<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 7/23/15
 * Time: 12:05 PM
 */
function getTemp($city='beijing'){
    $ch = curl_init();
    //$url = 'http://apis.baidu.com/apistore/weatherservice/cityname?citypinyin='.$city;
    $url = 'http://apis.baidu.com/apistore/weatherservice/cityname?cityname='.$city;
    $header = array(
        'apikey: 9e036045da7a654fcc2cd0fca8c8a7ca',
    );
// 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = json_decode(curl_exec($ch), true)['retData'];
    //$res = $res_tmp['retData'];

    $fRes = array(); //extract the data needed
    $fRes['pinyin']=$res['pinyin'];
    $fRes['date'] = $res['date'];
    $fRes['l_tmp'] = $res['l_tmp'];
    $fRes['h_tmp'] = $res['h_tmp'];
    $fRes['longitude'] = $res['longitude'];
    $fRes['latitude'] = $res['latitude'];
    $fRes['altitude'] = $res['altitude'];
    return $fRes;
    //return $res;
    //return gettype($url);
}

/* 该函数专门用来对城市温度表进行插入操作 */
function getItem($city='beijing'){
    $ch = curl_init();
    //$url = 'http://apis.baidu.com/apistore/weatherservice/cityname?citypinyin='.$city;
    $url = 'http://apis.baidu.com/apistore/weatherservice/cityname?cityname='.$city;
    $header = array(
        'apikey: 9e036045da7a654fcc2cd0fca8c8a7ca',
    );
// 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = json_decode(curl_exec($ch), true)['retData'];
    //$res = $res_tmp['retData'];

    $fRes = array(); //extract the data needed
    $fRes['pinyin']=$res['pinyin'];
    $fRes['date'] = $res['date'];
    $fRes['l_tmp'] = $res['l_tmp'];
    $fRes['h_tmp'] = $res['h_tmp'];
    return $fRes;
}
