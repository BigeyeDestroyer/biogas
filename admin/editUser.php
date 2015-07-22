<?php
require_once '../include.php';
checkLogined();
$rows=getAllProv();
if(!$rows){
    alertMes("没有相应省份，请先添加省份!!", "addProv.php");
}
$rows_city=getAllCity();
if(!$rows_city){
    alertMes("没有相应城市，请先添加城市!!","addCity.php");
}
$id=$_REQUEST['id'];
$userInfo=getUserById($id);
//print_r($userInfo);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>-.-</title>
    <link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
    <script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
    <script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
    <script>
        KindEditor.ready(function(K) {
            window.editor = K.create('#editor_id');
        });
        $(document).ready(function(){
            $("#selectFileBtn").click(function(){
                $fileField = $('<input type="file" name="thumbs[]"/>');
                $fileField.hide();
                $("#attachList").append($fileField);
                $fileField.trigger("click");
                $fileField.change(function(){
                    $path = $(this).val();
                    $filename = $path.substring($path.lastIndexOf("\\")+1);
                    $attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                    $attachItem.find(".left").html($filename);
                    $("#attachList").append($attachItem);
                });
            });
            $("#attachList>.attachItem").find('a').live('click',function(obj,i){
                $(this).parents('.attachItem').prev('input').remove();
                $(this).parents('.attachItem').remove();
            });
        });
    </script>
</head>
<body>
<h3>修改用户</h3>
<form action="doAdminAction.php?act=editUser&id=<?php echo $id?>" method="post" enctype="multipart/form-data">
    <table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">用户姓名</td>
            <td><input type="text" name="username"  value="<?php echo $userInfo['username'];?>"/></td>
        </tr>
        <tr>
            <td align="right">用户省份</td>
            <td>
                <select name="pId">
                    <?php foreach($rows as $row):?>
                        <option value="<?php echo $row['id'];?>" <?php echo $row['id']==$userInfo['pId']?"selected='selected'":null;?>><?php echo $row['province'];?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">用户城市</td>
            <td>
                <select name="cId">
                    <?php foreach($rows_city as $row):?>
                        <option value="<?php echo $row['id'];?>" <?php echo $row['id']==$userInfo['cId']?"selected='selected'":null;?>><?php echo $row['city'];?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">池容</td>
            <td><input type="text" name="capacity"  value="<?php echo $userInfo['capacity']?>"/></td>
        </tr>

        <tr>
            <td align="right">用户详细地址</td>
            <td><input type="text" name="address"  value="<?php echo $userInfo['address']?>"/></td>
        </tr>
        <tr>
            <td align="right">用户电话</td>
            <td><input type="text" name="phone"  value="<?php echo $userInfo['phone']?>"/></td>
        </tr>
        <tr>
            <td align="right">用户备注</td>
            <td>
                <textarea name="uDesc" id="editor_id" style="..."><?php echo $userInfo['uDesc']?></textarea>
            </td>
        </tr>
        <tr>
            <td align="right">沼气池图片</td>
            <td>
                <a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
                <div id="attachList" class="clear"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit"  value="编辑用户"/></td>
        </tr>
    </table>
</form>
</body>
</html>