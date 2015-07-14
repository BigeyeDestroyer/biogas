<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-18
 * Time: 下午10:42
 */
function alertMes($mes, $url){
    echo "<script>alert('{$mes}');</script>";
    echo "<script>window.location='{$url}';</script>";
}