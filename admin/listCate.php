<?php
require_once '../include.php';
$pageSize=2;
@$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;// “@”表示：即使有错误也不要输出，不过我们之前的warning是notice类型，所以无所谓
$sql="select * from imooc_cate";
$totalRows=getResultNum($sql);
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page)){
    $page=1;
}
if($page>=$totalPage){
    $page=$totalPage;
}
$offset=($page-1)*$pageSize;
$sql="select id,cName from imooc_cate order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
if(!$rows){
    alertMes("Sorry, no cate, add first!", "addCate.php");
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
            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addCate()">
        </div>

    </div>
    <!--表格-->
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="15%">编号</th>
            <th width="25%">分类名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $row):?>
            <tr>
                <!--这里的id和for里面的c1 需要循环出来-->
                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                <td><?php echo $row['cName'];?></td>
                <td align="center"><input type="button" value="修改" class="btn" onclick="editCate(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn" onclick="delCate(<?php echo $row['id'];?>)"></td>
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
    function addCate(){
        window.location="addCate.php";
    }
    function editCate(id){
        window.location="editCate.php?id="+id;
    }
    function delCate(id){
        if(window.confirm("Sure to delete? Can't recover after delete!!!")){
            window.location="doAdminAction.php?act=delCate&id="+id;
        }

    }
</script>
</html>