<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 7/23/15
 * Time: 5:04 PM
 */

$arr['pubDate']=time();
//print_r($arr['pubDate']);
echo date("y-m-d", $arr['pubDate']);
echo gettype(date("y-m-d", $arr['pubDate']));
phpinfo();

curl  --get --include  'http://apis.baidu.com/apistore/weatherservice/weather?citypinyin=changsha'  -H 'apikey:9e036045da7a654fcc2cd0fca8c8a7ca';

