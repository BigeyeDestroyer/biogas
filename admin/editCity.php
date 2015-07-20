<?php
require_once '../include.php';
$id=$_REQUEST['id'];
$row=getCityById($id);
//print_r($row);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<h3>修改城市</h3>
<form action="doAdminAction.php?act=editCity&id=<?php echo $id;?>" method="post">
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">城市名称</td>
            <td><input type="text" name="city" placeholder="<?php echo $row['city']?>"/></td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit" value="修改城市"/></td>
        </tr>

    </table>

</form>
</body>
</html>