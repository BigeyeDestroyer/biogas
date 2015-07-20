<?php
require_once '../lib/string.func.php';
header("content-type:text/html;charset=utf-8");
//$filename=$_FILES['myFile']['name'];
//$type=$_FILES['myFile']['type'];
//$tmp_name=$_FILES['myFile']['tmp_name'];
//$error=$_FILES['myFile']['error'];
//$size=$_FILES['myFile']['size'];

function buildInfo(){
    $i=0;
    foreach($_FILES as $v){
        // 单文件
        if(is_string($v['name'])){
            $files[$i]=$v;
            $i++;
        }else{
            //多文件
            foreach($v['name'] as $key=>$val){
                $files[$i]['name']=$val;
                $files[$i]['size']=$v['size'][$key];
                $files[$i]['tmp_name']=$v['tmp_name'][$key];
                $files[$i]['error']=$v['error'][$key];
                $files[$i]['type']=$v['type'][$key];
                $i++;
            }
        }
    }
    return $files;
}

function uploadFile($path="uploads",$allowExt=array("gif","jpeg","png","jpg","wbmp"),$maxSize=2097152,$imgFlag=true){
    if(!file_exists($path)){
        mkdir($path,0777,true);
    }
    $files=buildInfo();
    $i=0;
    foreach($files as $file){
        if($file['error']==UPLOAD_ERR_OK){
            $ext=getExt($file['name']);
            // 检查文件扩展名
            if(!in_array($ext,$allowExt)){
                exit("非法文件类型");
            }
            // 检查是否真正图片类型
            if($imgFlag){
                if(!getimagesize($file['tmp_name'])){
                    exit("不是真正图片类型");
                }
            }
            // 上传文件的大小
            if($file['size']>$maxSize){
                exit("上传文件过大");
            }
            // 是否通过HTTP POST上传
            if(!is_uploaded_file($file['tmp_name'])){
                exit("不是通过HTTP POST方式上传");
            }
            $filename=getUniName().".".$ext;
            $destination=$path."/".$filename;
            if(move_uploaded_file($file['tmp_name'],$destination)){
                $file['name']=$filename;
                unset($file['error'],$file['tmp_name'],$file['size'],$file['type']); //注销没用信息
                $uploadedFiles[$i]=$file;
                $i++;
            }
        }else{
            switch ($file['error']) {
                case 1:
                    $mes = "超过了配置文件上传文件的大小"; // UPLOAD_ERR_INI_SIZE
                    break;
                case 2:
                    $mes = "超过了表单设置上传文件的大小"; // UPLOAD_ERR_FORM_SIZE
                    break;
                case 3:
                    $mes = "文件部分被上传"; // UPLOAD_ERR_PARTIAL
                    break;
                case 4:
                    $mes = "没有文件被上传"; // UPLOAD_ERR_NO_FILE
                    break;
                case 6:
                    $mes = "没有找到临时目录"; // UPLOAD_ERR_NO_TMP_DIR
                    break;
                case 7:
                    $mes = "文件不可写"; // UPLOAD_ERR_CANT_WRITE
                    break;
                case 8:
                    $mes = "由于PHP的扩展程序终端了文件上传"; // UPLOAD_ERR_EXTENSION

            }
            echo $mes;
        }
    }
    return $uploadedFiles;
}