<?php
include('../config/common.conf.php');//引用公共样式和函数类库
		
if($type == "agentSend"){ /*代理数据*/
	$sql = "select id from tgs_agent where weixin = '$weixin'";
	$data = $mysql->get_one($sql);
				$output = array(); //-----------------liu
                $count = 5; //初始为5条
                @$start = @$_REQUEST['starts'];
                if(empty($start))
                {
                    $start = 0;
                } //-----------------------------liu
	$id= $data['id'];
	$output =array();
		$sqlorder = "select tor.shou_time,tor.order_inspected,tor.order_big,tor.order_small,tg.goods_pic,tg.goods_name,tor.order_toagentid from tgs_order as tor  left join tgs_agent as ta on  tor.order_agentid = ta.id left join tgs_goods as tg on tor.order_gid = tg.gid where tor.order_agentid = '$id' and tor.order_mode='1' order by tor.order_inspected,tor.order_time desc limit $start,$count";
		//echo $sqlorder;
		$rest = mysql_query($sqlorder);
	while($row = mysql_fetch_assoc($rest)){
		$sqlt2 = "select name from tgs_agent where id ='{$row['order_toagentid']}'";
		//echo $sqlt;
		$rest2 = mysql_query($sqlt2);
		while ($rowt = mysql_fetch_assoc($rest2)){
			$row['name']=$rowt['name'];
		}
	$output[]=$row;

	}
	echo json_encode($output);
}

if($type == "resale"){ /*零售数据*/
	$sql = "select id from tgs_agent where weixin = '$weixin'";
	$data = $mysql->get_one($sql);
				$output = array(); //-----------------liu
                $count = 5; //初始为5条
                @$start = @$_REQUEST['start'];
                if(empty($start))
                {
                    $start = 0;
                } //-----------------------------liu
	$id= $data['id'];
	$output =array();
		$sqlorder = "select tor.order_time,tor.order_big,tor.order_small,tg.goods_pic,tg.goods_name,tor.order_toagentid from tgs_order as tor  left join tgs_agent as ta on  tor.order_agentid = ta.id left join tgs_goods as tg on tor.order_gid = tg.gid where tor.order_agentid = '$id' and tor.order_mode='0' order by tor.order_time desc limit $start,$count";
		//echo $sqlorder;
		$rest = mysql_query($sqlorder);
	while($row = mysql_fetch_assoc($rest)){

		$sqlt2 = "select name from tgs_agent where id ='{$row['order_toagentid']}'";
		//echo $sqlt;
		$rest2 = mysql_query($sqlt2);
		while ($rowt = mysql_fetch_assoc($rest2)){

			$row['name']=$rowt['name'];
		}

	$output[]=$row;
	}

echo json_encode($output);
}

?>