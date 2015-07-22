<?php 
require_once '../include.php';
error_reporting(E_ALL^E_NOTICE); // !!! shutdown the reporting of notices !!!
checkLogined();
$order=$_REQUEST['order']?$_REQUEST['order']:null;
$orderBy=$order?"order by u.".$order:null;
$keywords=$_REQUEST['keywords']?$_REQUEST['keywords']:null;
$where=$keywords?"where u.username like '%{$keywords}%'":null;
//得到数据库中所有用户
$sql="select u.id,u.username,u.pId,u.cId,u.capacity,u.address,u.phone,u.uDesc,u.pubTime,p.province, c.city from biogas_user as u join biogas_prov p on u.pId=p.id join biogas_city c on u.cId=c.id {$where}";
$totalRows=getResultNum($sql);
$pageSize=4;
$totalPage=ceil($totalRows/$pageSize);
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select u.id,u.username,u.pId,u.cId,u.capacity,u.address,u.phone,u.uDesc,u.pubTime,p.province, c.city from biogas_user as u join biogas_prov p on u.pId=p.id join biogas_city c on u.cId=c.id {$where} {$orderBy} limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link rel="stylesheet" href="styles/backstage.css">
<link rel="stylesheet" href="scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<script src="scripts/jquery-ui/js/jquery-1.10.2.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript">
        function showDetail(id,t){
            $("#showDetail"+id).dialog({
                height:"auto",
                width: "auto",
                position: {my: "center", at: "center",  collision:"fit"},
                modal:false,//是否模式对话框
                draggable:true,//是否允许拖拽
                resizable:true,//是否允许拖动
                title:"用户姓名："+t,//对话框标题
                show:"slide",
                hide:"explode"
            });
        }
        function addUser(){
            window.location='addUser.php';
        }
        function editUser(id){
            window.location='editUser.php?id='+id;
        }
        function delUser(id){
            if(window.confirm("您确认要删除吗？")){
                window.location="doAdminAction.php?act=delUser&id="+id;
            }
        }
        function search(){
            if(event.keyCode==13){
                var val=document.getElementById("search").value;
                window.location="listUser.php?keywords="+val;
            }
        }
        function change(val){
            window.location="listUser.php?order="+val;
        }
    </script>
</head>

<body>
<div id="showDetail"  style="display:none;">
</div>
<div class="details">
    <div class="details_operation clearfix">
        <div class="bui_select">
            <input type="button" value="添&nbsp;&nbsp;加" class="add" onclick="addUser()">
        </div>
        <div class="fr">
            <div class="text">
                <span>池容：</span>
                <div class="bui_select">
                    <select id="" class="select" onchange="change(this.value)">
                        <option>-请选择-</option>
                        <option value="iPrice asc" >由低到高</option>
                        <option value="iPrice desc">由高到底</option>
                    </select>
                </div>
            </div>
            <div class="text">
                <span>建立时间：</span>
                <div class="bui_select">
                    <select id="" class="select" onchange="change(this.value)">
                        <option>-请选择-</option>
                        <option value="pubTime desc" >最新建立</option>
                        <option value="pubTime asc">历史建立</option>
                    </select>
                </div>
            </div>
            <div class="text">
                <span>搜索</span>
                <input type="text" value="" class="search"  id="search" onkeypress="search()" >
            </div>
        </div>
    </div>
    <!--表格-->
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="10%">编号</th>
            <th width="10%">用户姓名</th>
            <th width="10%">用户省份</th>
            <th width="10%">用户电话</th>
            <th width="15%">建立时间</th>
            <th width="20%">池容(立方米)</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1;foreach($rows as $row):?>  <!-- "$i = 1;" not know why ??? -->
            <tr>
                <!--这里的id和for里面的c1 需要循环出来-->
                <td align="center"><input type="checkbox" id="c<?php echo $row['id'];?>" class="check" value=<?php echo $row['id'];?>><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                <td align="center"><?php echo $row['username']; ?></td>
                <td align="center"><?php echo $row['province'];?></td>
                <td align="center"><?php echo $row['phone'];?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$row['pubTime']);?></td>
                <td align="center"><?php echo $row['capacity'];?></td>
                <td align="center">
                    <input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['id'];?>,'<?php echo $row['username'];?>')"><input type="button" value="修改" class="btn" onclick="editUser(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn"onclick="delUser(<?php echo $row['id'];?>)">
                    <div id="showDetail<?php echo $row['id'];?>" style="display:none;">
                        <table class="table" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%" align="right">用户姓名</td>
                                <td><?php echo $row['username'];?></td>
                            </tr>
                            <tr>
                                <td width="20%"  align="right">用户省份</td>
                                <td><?php echo $row['province'];?></td>
                            </tr>
                            <tr>
                                <td width="20%"  align="right">用户城市</td>
                                <td><?php echo $row['city'];?></td>
                            </tr>
                            <tr>
                                <td width="20%"  align="right">池容</td>
                                <td><?php echo $row['capacity'];?></td>
                            </tr>
                            <tr>
                                <td  width="20%"  align="right">详细地址</td>
                                <td><?php echo $row['address'];?></td>
                            </tr>
                            <tr>
                                <td  width="20%"  align="right">电话</td>
                                <td><?php echo $row['phone'];?></td>
                            </tr>
                            <tr>
                                <td width="20%"  align="right">用户图片</td>
                                <td>
                                    <?php
                                    $userImgs=getAllImgByUserId($row['id']);
                                    foreach($userImgs as $img):
                                        ?>
                                        <img width="100" height="100" src="../uploads/<?php echo $img['albumPath'];?>" alt=""/> &nbsp;&nbsp;
                                    <?php endforeach?>
                                </td>
                            </tr>
                        </table>
                        <span style="display:block;width:80%; ">
                            备注<br/>
                            <?php echo $row['uDesc'];?>
                        </span>
                    </div>
                                
                </td>
            </tr>
            <?php  $i++; endforeach;?>    <!--  "$i++;" not know why  -->
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="7"><?php echo showPage($page, $totalPage,"keywords={$keywords}&order={$order}");?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
    </div>

</body>
</html>