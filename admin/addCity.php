<?php
require_once '../include.php';
checkLogined();
$rows=getAllProv();
if(!$rows){
    alertMes("没有省份，请先添加省份!!", "addProv.php");
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>^_^</title>
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
<h3>添加城市</h3>
<form action="doAdminAction.php?act=addCity" method="post">
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="left">城市名称</td>
            <td><input type="text" name="city" placeholder="请输入城市名称"/></td>
        </tr>

        <tr>
            <td align="left">城市省份</td>
            <td>
                <select name="pId">
                    <?php foreach($rows as $row):?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['province'];?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit" value="添加城市"/></td>
        </tr>

    </table>

</form>
</body>
</html>