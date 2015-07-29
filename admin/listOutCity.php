<?php
require_once '../include.php';
error_reporting(E_ALL&~E_NOTICE&~E_WARNING); // !!! shutdown the reporting of notices and warnings!!!
checkLogined();
$order=$_REQUEST['order']?$_REQUEST['order']:null;
$orderBy=$order?"order by c.".$order:null;
$keywords=$_REQUEST['keywords']?$_REQUEST['keywords']:null;
$where=$keywords?"where c.city like '%{$keywords}%'":null;
//得到数据库中所有用户
$sql="select c.id,c.city,c.longitude,c.latitude,c.totalCap,c.pubDate from biogas_city as c {$where}";
$totalRows=getResultNum($sql);
$pageSize=6;
$totalPage=ceil($totalRows/$pageSize);
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
//$sql="select u.id,u.username,u.pId,u.cId,u.capacity,u.address,u.phone,u.uDesc,u.pubTime,p.province, c.city from biogas_user as u join biogas_prov p on u.pId=p.id join biogas_city c on u.cId=c.id {$where} {$orderBy} limit {$offset},{$pageSize}";
$sql="select c.id,c.city,c.longitude,c.latitude,c.totalCap,c.pubDate from biogas_city as c {$where} {$orderBy} limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>-.-</title>
    <link rel="stylesheet" href="styles/backstage.css">
    <link rel="stylesheet" href="scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link href="../jquery/jquery-ui.css" rel="stylesheet">
    <script src="scripts/jquery-ui/js/jquery-1.10.2.js"></script>
    <script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript">
        function search(){
            if(event.keyCode==13){
                var val=document.getElementById("search").value;
                window.location="listOutCity.php?keywords="+val;
            }
        }
        function change(val){
            window.location="listOutCity.php?order="+val;
        }
        function query(){
            window.location="queryUser.php";
        }
    </script>
    <style>
        body{
            font: 62.5% "Trebuchet MS", sans-serif;
            margin: 50px;
        }
        .demoHeaders {
            margin-top: 2em;
        }
        #dialog-link {
            padding: .4em 1em .4em 20px;
            text-decoration: none;
            position: relative;
        }
        #dialog-link span.ui-icon {
            margin: 0 5px 0 0;
            position: absolute;
            left: .2em;
            top: 50%;
            margin-top: -8px;
        }
        #icons {
            margin: 0;
            padding: 0;
        }
        #icons li {
            margin: 2px;
            position: relative;
            padding: 4px 0;
            cursor: pointer;
            float: left;
            list-style: none;
        }
        #icons span.ui-icon {
            float: left;
            margin: 0 4px;
        }
        .fakewindowcontain .ui-widget-overlay {
            position: absolute;
        }
        select {
            width: 200px;
        }
    </style>
</head>

<body>
<div id="showDetail"  style="display:none;">
</div>
<div class="details">
    <div class="details_operation clearfix">
        <div class="fr">
            <div class="text">
                <span>城市总池容：</span>
                <div class="bui_select">
                    <select id="" class="select" onchange="change(this.value)">
                        <option>-请选择-</option>
                        <option value="totalCap asc" >由低到高</option>
                        <option value="totalCap desc">由高到底</option>
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
            <th width="5%">编号</th>
            <th width="10%">城市</th>
            <th width="10">经度</th>
            <th width="10">纬度</th>
            <th width="10%">总池容(m^3)</th>
            <th width="10%">建立时间</th>
            <th width="20%">起止查询时间</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1;foreach($rows as $row):?>  <!-- "$i = 1;" not know why ??? -->
            <tr>
                <!--这里的id和for里面的c1 需要循环出来-->
                <td align="center"><input type="checkbox" id="c<?php echo $row['id'];?>" class="check" value=<?php echo $row['id'];?>><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                <td align="center"><?php echo $row['city']; ?></td>
                <td align="center"><?php echo $row['longitude'] ?></td>
                <td align="center"><?php echo $row['latitude'] ?></td>
                <td align="center"><?php echo $row['totalCap'] ?></td>
                <td align="center"><?php echo $row['pubDate'];?></td>
                <td align="center">
                    <form action="temp_char_city.php?id=<?php $id=$row['id'];echo $id?>" method="post">
                        <table border="1" cellpadding="5" cellspacing="0">
                            <td><input type="text" id=<?php echo "\""."datepicker".(2*$i-1)."\"";?>, placeholder="起始查询时间" name="bTime"/></td>
                            <td><input type="text" id=<?php echo "\""."datepicker".(2*$i)."\"";?>, placeholder="终止查询时间" name="eTime"/></td>
                            <td colspan="2"><input type="submit" value="查询" /></td>
                        </table>
                    </form>
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
<script src="../jquery/external/jquery/jquery.js"></script>
<script src="../jquery/jquery-ui.js"></script>
<script>
    $( "#datepicker1" ).datepicker({
        inline: true
    });
    $( "#datepicker2" ).datepicker({
        inline: true
    });
    $( "#datepicker3" ).datepicker({
        inline: true
    });
    $( "#datepicker4" ).datepicker({
        inline: true
    });
    $( "#datepicker5" ).datepicker({
        inline: true
    });
    $( "#datepicker6" ).datepicker({
        inline: true
    });
    $( "#datepicker7" ).datepicker({
        inline: true
    });
    $( "#datepicker8" ).datepicker({
        inline: true
    });
    $( "#datepicker9" ).datepicker({
        inline: true
    });
    $( "#datepicker10" ).datepicker({
        inline: true
    });
</script>
</body>
</html>