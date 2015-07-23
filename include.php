<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-19
 * Time: 上午9:49
 */
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
session_start();  // 曾因此报错
define("ROOT",dirname(__FILE__));
set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/configs".PATH_SEPARATOR.ROOT."/core".PATH_SEPARATOR.get_include_path());
require_once 'common.func.php';
require_once 'image.func.php';
require_once 'mysql.func.php';
require_once 'page.func.php';
require_once 'string.func.php';
require_once 'temp.func.php';
require_once 'upload.func.php';
require_once 'configs.php';
require_once 'admin.inc.php';
require_once 'prov.inc.php';
require_once 'city.inc.php';
require_once 'user.inc.php';
require_once 'album.inc.php';
connect();