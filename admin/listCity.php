<?php
require_once '../include.php';
$pageSize=4;
@$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;// “@”表示：即使有错误也不要输出，不过我们之前的warning是notice类型，所以无所谓
$sql="select * from biogas_city";
$totalRows=getResultNum($sql);
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page)){
    $page=1;
}
if($page>=$totalPage){
    $page=$totalPage;
}
$offset=($page-1)*$pageSize;
$sql="select id,city from biogas_city order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
if(!$rows){
    alertMes("对不起, 没有城市, 请先添加!", "addCity.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="styles/backstage.css">
</head>
<body>
<div class="details">
    <div class="details_operation clearfix">
        <div class="bui_select">
            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addCity()">
        </div>

    </div>
    <!--表格-->
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="15%">编号</th>
            <th width="25%">省份名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $row):?>
            <tr>
                <!--这里的id和for里面的c1 需要循环出来-->
                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                <td><?php echo $row['city'];?></td>
                <td align="center"><input type="button" value="修改" class="btn" onclick="editCity(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn" onclick="delCity(<?php echo $row['id'];?>)"></td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="4"><?php echo showPage($page,$totalPage)?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
</body>

<script type="text/javascript">
    function addCity(){
        window.location="addCity.php";
    }
    function editCity(id){
        window.location="editCity.php?id="+id;
    }
    function delCity(id){
        if(window.confirm("确认删除? 删除后无法恢复!!!")){
            window.location="doAdminAction.php?act=delCity&id="+id;
        }

    }
</script>
</html>