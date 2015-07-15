<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 15-5-18
 * Time: 下午10:41
 */
//require_once '../include.php';
//$sql="select * from imooc_admin";
//$totalRows=getResultNum($sql);
////echo $totalRows;
//$pageSize=2;
//// Get the total number of pages
//$totalPage=ceil($totalRows/$pageSize);
//if(isset($_REQUEST['page'])){
//    $page=(int)$_REQUEST['page'];
//}else{
//    $page=1;
//}
////$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
//if($page<1||$page==null||!is_numeric($page)){
//    $page=1;
//}
//if($page>=$totalPage){
//    $page=$totalPage;
//}
//$offset=($page-1)*$pageSize;
//$sql="select * from imooc_admin limit {$offset},{$pageSize}";
//$rows=fetchAll($sql);
////print_r($rows);
//foreach($rows as $row){
//    echo "Id: ".$row['id'],"<br/>";
//    echo "Admin Name: ".$row['username'],"<hr/>";
//}
//
//echo showPage($page,$totalPage);
//echo "<hr/>";
//echo showPage($page,$totalPage,"cid=5&pid=6");
function showPage($page, $totalPage,$where=null,$sep="&nbsp;")
{
    $where=($where==null)?null:"&".$where;
    $url = $_SERVER['PHP_SELF'];
    $index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
    $last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
    $prev = ($page == 1) ? "上一页" : "<a href='{$url}?page=" . ($page - 1) . "{$where}'>上一页</a>";
    $next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page=" . ($page + 1) . "{$where}'>下一页</a>";
    $str = "总共{$totalPage}页/当前是第{$page}页";
    $p = null; // In case that a "Notice: undefined variable" is thrown up
    for ($i = 1; $i <= $totalPage; $i++) {
        if ($page == $i) {
            $p .= "[{$i}]";
        } else {
            $p .= "<a href='{$url}?page={$i}'>[{$i}]</a>";
        }
    }
    echo "<hr/>";
    $pageStr=$str.$sep.$index.$sep.$prev.$sep.$p.$sep.$next.$sep.$last;
    return $pageStr;
}