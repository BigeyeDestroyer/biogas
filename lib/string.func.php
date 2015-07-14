<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-18
 * Time: 下午10:41
 */
function buildRandomString($type=1, $length=4)
{
    if ($type == 1) {
        $chars = join("", range(0, 9));
    } elseif ($type == 2) {
        $chars = join("", array_merge(range("a", "z"), range("A", "Z")));
    } elseif ($type == 3) {
        $chars = join("", array_merge(range("a", "z"), range("A", "Z"), range(0, 9)));
    }

    if ($length > strlen($chars)) {
        exit("字符串长度不够");
    }

    $chars = str_shuffle($chars);
    return substr($chars, 0, $length);
}

/*
 * Get unique string
 *
 * */
function getUniName(){
    return md5(uniqid(microtime(true), true)); // 返回一个唯一字符串
}

/*
 * Get the file extension name
 * */
function getExt($filename){
    return strtolower(end(explode(".", $filename)));
}