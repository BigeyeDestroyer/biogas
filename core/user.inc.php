<?php 
/**
 * 添加用户
 * @return string
 */
require_once '../include.php';

function addUser(){
	$arr=$_POST;
	$arr['pubTime']=time();
	$path="../uploads";
	$uploadFiles=uploadFile($path);

    $totalCap = $arr['capacity']+getCityCapById($arr['cId']);
    $sql = "update biogas_city set totalCap=".$totalCap." where id=".$arr['cId'];
    mysql_query($sql); //更新城市的总池容

	$res=insert("biogas_user",$arr);
	$uid=getInsertId();
	if($res&&$uid){
        if($uploadFiles&&is_array($uploadFiles)){
            foreach($uploadFiles as $uploadFile){
                $arr1['uid']=$uid;
                $arr1['albumPath']=$uploadFile['name'];
                addAlbum($arr1);
            }
        }
        $mes="<p>添加成功!</p><a href='addUser.php' target='mainFrame'>继续添加</a>|<a href='listUser.php' target='mainFrame'>查看用户列表</a>";
	}else{
		$mes="<p>添加失败!</p><a href='addUser.php' target='mainFrame'>重新添加</a>";
	}
	return $mes;
}

/*   addUser()函数没有问题！！！ */
/**
 *编辑商品
 * @param int $id
 * @return string
 */
function editUser($id){
	$arr=$_POST;
	$path="../uploads";
	$uploadFiles=uploadFile($path);
	$where="id={$id}";

    $totalCap = getCityCapById(getcIdById($id))-getCapById($id)+$arr['capacity']; //减去旧的，加上新的
    $sql = "update biogas_city set totalCap=".$totalCap." where id=".getcIdById($id);
    mysql_query($sql); //更新城市的总池容

	$res=update("biogas_user",$arr,$where);
	$uid=$id;
	if($res&&$uid){
		if($uploadFiles &&is_array($uploadFiles)){
			foreach($uploadFiles as $uploadFile){
				$arr1['uid']=$uid;
				$arr1['albumPath']=$uploadFile['name'];
				addAlbum($arr1);
			}
		}
		$mes="<p>编辑成功!</p><a href='listUser.php' target='mainFrame'>查看用户列表</a>";
	}else{
		$mes="<p>编辑失败!</p><a href='listUser.php' target='mainFrame'>重新编辑</a>";
	}
	return $mes;
}

/*!!! editUser() 函数没有问题 !!! */

function delUser($id){
	$where="id=$id";

    $totalCap = getCityCapById(getcIdById($id))-getCapById($id);
    $sql = "update biogas_city set totalCap=".$totalCap." where id=".getcIdById($id);
    mysql_query($sql); //更新城市的总池容

	$res=delete("biogas_user",$where);
	$userImgs=getAllImgByUserId($id);
	if($userImgs&&is_array($userImgs)){
		foreach($userImgs as $userImg){
			if(file_exists("../uploads/".$userImg['albumPath'])){
				unlink("../uploads/".$userImg['albumPath']);
			}
		}
	}
	$where1="uid={$id}";
    if($userImgs&&is_array($userImgs)){
        $res1=delete("biogas_album",$where1);
        if($res&&$res1){
            $mes="删除成功!<br/><a href='listUser.php' target='mainFrame'>查看用户列表</a>";
        }else{
            $mes="删除失败!<br/><a href='listUser.php' target='mainFrame'>重新删除</a>";
        }
    }else{
        if($res){
            $mes="删除成功!<br/><a href='listUser.php' target='mainFrame'>查看用户列表</a>";
        }else{
            $mes="删除失败!<br/><a href='listUser.php' target='mainFrame'>重新删除</a>";
        }
    }


	return $mes;
}

/*!!! delUser() 函数没有问题 !!!*/

/* 得到某个用户在一段时间内沼气的产量 */
function queryTemp($id){
    $cId = getcIdById($id);
    $pinyin = getPinyinById($cId)['pinyin'];
    $capacity = getCapById($id);

    $arr = $_POST;

    $bTemp = $arr['bTime'];
    $lb = strlen($bTemp);
    $bTime = substr($bTemp,$lb-2,2)."-".substr($bTemp,0,2)."-".substr($bTemp,3,2); // string

    $eTemp = $arr['eTime'];
    $le = strlen($eTemp);
    $eTime = substr($eTemp,$le-2,2)."-".substr($eTemp,0,2)."-".substr($eTemp,3,2); // string

    $bsql = "select id from ".$pinyin."_tmp where date="."\"".$bTime."\"";
    $esql = "select id from ".$pinyin."_tmp where date="."\"".$eTime."\"";

    $bId = fetchOne($bsql)['id'];
    $eId = fetchOne($esql)['id']; // 得到两个日期所对应的id

    $l_sql = "select l_tmp from ".$pinyin."_tmp where id>=".$bId." and id<=".$eId;
    $h_sql = "select h_tmp from ".$pinyin."_tmp where id>=".$bId." and id<=".$eId;
    $d_sql = "select date from ".$pinyin."_tmp where id>=".$bId." and id<=".$eId; // get all the date

    $l_tmp = fetchAll($l_sql);
    $l_res = array(); // low_temperature
    $h_tmp = fetchAll($h_sql);
    $h_res = array(); // high_temperature
    $m_res = array(); // mid_temperature
    $d_tmp = fetchAll($d_sql); // 得到日期
    $d_res = array(); // the date, 用以存储日期的简洁形式
    $gas_res = array(); // 产气量
    $gas_total = 0;
    for($i=0;$i<count($l_tmp);$i++){
        $l_res[$i]=$l_tmp[$i]['l_tmp'];
        $h_res[$i]=$h_tmp[$i]['h_tmp'];
        $m_res[$i] = ($h_res[$i] + $l_res[$i]) / 2;
        $gas_res[$i] = (0.01 * $m_res[$i] - 0.02) * $capacity;
        if($gas_res[$i]<0){ // 即不产生沼气的情况
            $gas_res[$i] = 0;
        }
        $gas_total = $gas_total + $gas_res[$i];

        // from 2015-7-31 to 7/31
        $d_res[$i] = $d_tmp[$i]['date'];
        $d_res[$i] = substr($d_res[$i],strlen($d_res[$i])-5, 5);
        $d_res[$i][2] = "/";
    }
    $res = array();
    $res[0] = $gas_res; // 沼气产量数组
    $res[1] = $d_res; // 日期数组
    $res[2] = $gas_total; // 沼气总量
    $res[3] = $m_res; // 平均温度数组
    return $res;
//    print_r($res);
//    print_r($m_res);
//    print_r($d_res);
//    print_r($gas_res);
//    print_r($capacity);
//    print_r($gas_total/count($gas_res));
}

/*function queryUser($id){
    echo $id;
}*/
/**
 * 得到所有用户信息
 * @return array
 */
function getAllUserByAdmin(){
    $sql="select u.id,u.username,u.pId,u.cId,u.capacity,u.address,u.phone,u.uDesc,u.pubTime,p.province, c.city from biogas_user as u join biogas_prov p on u.pId=p.id join biogas_city c on u.cId=c.id";
    $rows=fetchAll($sql);
	return $rows;
}
/* !!! getAllUserByAdmin() 函数没有问题 !!! */

/**
 *根据用户id得到用户图片
 * @param int $id
 * @return array
 */
function getAllImgByUserId($id){
	$sql="select a.albumPath from biogas_album a where a.uid={$id}";
	$rows=fetchAll($sql);
	return $rows;
}
/* !!! getAllImgByUserId() 函数没有问题 !!! */

/**
 * 根据id得到用户的详细信息
 * @param int $id
 * @return array
 */
function getUserById($id){
    $sql="select u.id,u.username,u.pId,u.cId,u.capacity,u.address,u.phone,u.uDesc,u.pubTime,p.province, c.city from biogas_user as u join biogas_prov p on u.pId=p.id join biogas_city c on u.cId=c.id where u.id={$id}";
    $row=fetchOne($sql);
	return $row;
}
/* !!! getUserById() 函数没有问题 !!! */

function getcIdById($id){
    $sql="select cId from biogas_user where id={$id}";
    $row=fetchOne($sql);
    return $row['cId'];
}

function getAreaById($id){
    $csql="select cId from biogas_user where id={$id}";
    $cId = fetchOne($csql)['cId'];
    $psql="select pId from biogas_user where id={$id}";
    $pId = fetchOne($psql)['pId'];
    $res = getProvById($pId)['province']."省".getCityById($cId)['city']."市";
    return $res;
}

function getCapById($id){
    $sql="select capacity from biogas_user where id={$id}";
    $row=fetchOne($sql);
    return $row['capacity'];
}

function getNameById($id){
    $sql="select username from biogas_user where id={$id}";
    $row=fetchOne($sql);
    return $row['username'];
}

/**
 * 检查分类下是否有产品
 * @param int $cid
 * @return array
 */
function checkProExist($cid){
	$sql="select * from imooc_pro where cId={$cid}";
	$rows=fetchAll($sql);
	return $rows;
}

/**
 * 得到所有商品
 * @return array
 */
function getAllPros(){
	$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id ";
	$rows=fetchAll($sql);
	return $rows;
}

/**
 *根据cid得到4条产品
 * @param int $cid
 * @return Array
 */
function getProsByCid($cid){
	$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4";
	$rows=fetchAll($sql);
	return $rows;
}

/**
 * 得到下4条产品
 * @param int $cid
 * @return array
 */
function getSmallProsByCid($cid){
	$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4,4";
	$rows=fetchAll($sql);
	return $rows;
}

/**
 *得到商品ID和商品名称
 * @return array
 */
function getProInfo(){
	$sql="select id,pName from imooc_pro order by id asc";
	$rows=fetchAll($sql);
	return $rows;
}
