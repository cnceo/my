<?php
echo '<link type="text/css" rel="stylesheet" href="/skin/main/main.css" />
<style type="text/css">
.table_3{font-size:12px;margin:0;background:#1b1b1b;border-collapse:separate;border-spacing:1px;}
.table_3 th{background:#282828;width:80px;height:25px;line-height:25px;}
.table_3 td{padding:3px 5px;background:#282828;color:#888;text-align:left;text-align:left;}
.table_3 textarea {font-size:12px;color:#888;overflow-y:auto;width:408px;height:158px;border:0;background:#282828;resize:none;
}
</style>
';
$bet=$this->getRow("select b.*, u.parents parents, l.coin coinFanDian from {$this->prename}bets b, {$this->prename}members u, {$this->prename}coin_log l where b.uid=u.uid and b.uid=l.uid and l.liqType=2 and l.extfield0=b.id and b.id=?",$args[0]);
if(!$bet) $bet=$this->getRow("select b.*, u.parents parents from {$this->prename}members u, {$this->prename}bets b where b.uid=u.uid and b.id=?",$args[0]);
$modeName=array('2.00'=>'元','0.20'=>'角','0.02'=>'分');
$weiShu=$bet['weiShu'];
if($weiShu){
if(game.type==7){
$w=array(8=>'自',4=>'仰',2=>'蛙',1=>'蝶');
}else{
$w=array(16=>'万',8=>'千',4=>'百',2=>'十',1=>'个');
}
foreach($w as $p=>$v){
if($weiShu &$p) $wei.=$v;
}
$wei.=':';
}
$parents=explode(','.$this->user['uid'].',',','.$bet['parents']);
if($parents[1]) $parents[1]=$this->user['uid'].",".$parents[1];
$betCont=$bet['mode'] * $bet['beiShu'] * $bet['actionNum'];
;echo '<div class="bet-info popupModal">
	<table border="0" cellpadding="0" cellspacing="1" class="table_3" width="480">
		<tr>
		  <th align="right">发起人：</th>
		  <td width="158">';echo preg_replace('/^(\w).*(\w{2})$/','\1***\2',$bet['username']);echo '</td>
		  <th align="right">方案编号：</th>
		  <td width="158">';echo $bet['actionTime'];echo '';echo $bet['id'];echo '			';
if($bet['isDelete']==1){
echo '<font color="#999999">已撤单</font>';
}elseif(!$bet['lotteryNo']){
echo '<font color="#cccccc">未开奖</font>';
}elseif($bet['zjCount']){
echo '<font color="red">已派奖</font>';
}else{
echo '<font color="green">未中奖</font>';
}
;echo '          </td>
		</tr>
		<tr>
			<th align="right">彩种玩法：</th>
			<td>';echo $this->types[$bet['type']]['title'];echo ' ';echo $this->playeds[$bet['playedId']]['name'];echo '</td>
			<th align="right">奖金模式：</th>
			<td>';echo number_format($bet['bonusProp'],2);echo ' / ';echo number_format($bet['fanDian'],1);echo '% / ';echo $modeName[$bet['mode']];echo '</td>
		</tr>
		<tr>
			<th align="right">期号：</th>
			<td>';echo $bet['actionNo'];echo '</td>
			<th align="right">投注时间：</th>
			<td>';echo date('m-d H:i:s',$bet['actionTime']);echo '</td>
		</tr>
		<tr>
			<th align="right">投注金额：</th>
			<td>共';echo $bet['actionNum'];echo '注×';echo $bet['beiShu'];echo '倍=';echo number_format($betCont,2);echo '元</td>
			<th align="right">中奖注数：</th>
			<td>中奖 ';echo $this->iff($bet['lotteryNo'],$bet['zjCount'],'－');echo ' 注</td>
		</tr>
		<tr>
			<th align="right">奖金返点：</th>
			<td>';echo $this->iff($bet['lotteryNo'],number_format($bet['bonus'],2) .'元','－');echo ' / ';echo $this->iff($bet['lotteryNo'],number_format(($bet['fanDian']/100)*$betCont,2).'元','－');echo '</td>
			<th align="right">盈亏金额：</th>
			<td>';echo $this->iff($bet['lotteryNo'],number_format($bet['bonus'] -$betCont +($bet['fanDian']/100)*$betCont,2) .'元','－');echo '</td>
		</tr>
		';if($this->user['uid']==$bet['qz_uid']){;echo '		<tr>
			<th align="right">抢庄状态：</th>
			<td colspan="3">';echo $this->iff($bet['qzEnable'],'已发起','未发起');echo '				';
if($bet['qz_username']!=$this->user['username']){
if($bet['qz_username']){echo preg_replace('/^(\w).*(\w{2})$/','\1***\2',$bet['qz_username']);}else{echo '';};
}else{
if($bet['qz_username']){echo'<font color="#ff0000">'.$bet['qz_username'].'</font>';}else{echo '';};
}
;echo ' ';echo $this->iff($bet['qz_uid'],'抢庄成功','未抢');echo '</td>
		</tr>
		<!-- 抢庄开始　-->
		<tr>
			<td align="right">抢庄投注：</td>
			<td>';echo number_format($bet['beiShu'] * $bet['mode'] * $bet['actionNum'],2);echo '</td>
			<td align="right">抢庄返点：</td>
			<td>';echo number_format(-($bet['fanDian']/100)*$betCont,2);echo '</td>
		</tr>
		<tr>
			<td align="right">抢庄赔付：</td>
			<td>';echo number_format(-$bet['bonus'] -($bet['fanDian']/100)*$betCont -$bet['qz_chouShui'],2);echo '</td>
			<td align="right">抢庄盈亏：</td>
			<td>';echo number_format($bet['beiShu'] * $bet['mode'] * $bet['actionNum'] -$bet['bonus'] -($bet['fanDian']/100)*$betCont -$bet['qz_chouShui'],2);echo '</td>
		</tr>
		<!-- 抢庄结束 -->
		';};echo '		<tr>
			<th align="right">开奖号码：</th>
			';if($parents[1]){;echo '            <td colspan="3">';echo $this->ifs($bet['lotteryNo'],'－');echo '</td>
			';}else{;echo '            <td colspan="3">';echo $this->ifs($bet['lotteryNo'],'－');echo '			';};echo '</td>
		</tr>
		<tr>
			<th align="right" valign="top">方案号码：</th>
			<td colspan="3"><textarea cols="60" rows="9" readonly="readonly">';echo $wei.$bet['actionData'];echo '</textarea></td>
		</tr>
        <!--tr>
        	<td align="right">来源：</td>
            <td colspan="3">';if($bet['betType']==0){echo 'web端';}else if($bet['betType']==1){echo '手机端';}else if($bet['betType']==2){echo '客户端';};echo '</td>
        </tr-->
	</table>
</div>';
?>