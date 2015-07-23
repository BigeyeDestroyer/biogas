<?php 
/**
 * 添加用户
 * @return string
 */
function addUser(){
	$arr=$_POST;
	$arr['pubTime']=time();
	$path="../uploads";
	$uploadFiles=uploadFile($path);
	$res=insert("biogas_user",$arr);
	$uid=getInsertId();
	if($res&&$uid){
		foreach($uploadFiles as $uploadFile){
			$arr1['uid']=$uid;
			$arr1['albumPath']=$uploadFile['name'];
			addAlbum($arr1);
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
