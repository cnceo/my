<?php

class WebBase extends Object{
public $controller;
public $action;
public $memberSessionName='member-session-name';
public $user;
public $headers;
public $page=1;
public $title='IFC-英利国际';
public $params=array();
public $types;
public $playeds;
private $expire=3600;
public $urlPasswordKey='K#6r%Z*=$Rk9#Rjv.(Q!].tbrNfR.*';
function __construct($dsn,$user='',$password=''){
session_start();
try{
parent::__construct($dsn,$user,$password);
if($_SESSION[$this->memberSessionName]){
$this->user=unserialize($_SESSION[$this->memberSessionName]);
$this->updateSessionTime();
}
}catch(Exception $e){
}
}
public function getSystemSettings($expire=null){
if($expire===null) $expire=$this->expire;
$file=$this->cacheDir .'/systemSettings';
if($expire &&is_file($file) &&filemtime($file)+$expire>$this->time){
return $this->settings=unserialize(file_get_contents($file));
}
$sql="select * from ssc_params";
$this->settings=array();
if($data=$this->getRows($sql)){
foreach($data as $var){
$this->settings[$var['name']]=$var['value'];
}
}
file_put_contents($file,serialize($this->settings));
return $this->settings;
}
public function getTypes(){
if($this->types) return $this->types;
$sql="select * from {$this->prename}type where isDelete=0";
return $this->types=$this->getObject($sql,'id',null,$this->expire);
}
public function getPlayeds(){
if($this->playeds) return $this->playeds;
$sql="select * from {$this->prename}played";
return $this->playeds=$this->getObject($sql,'id',null,$this->expire);
}
public function getSystemConfig(){
$file=$this->cacheDir .'FDJSALKFJSIDFJSKLJFFSJDafkljdasa5235465723';
if(is_file($file) &&filemtime($file)+$this->expire>$this->time){
$this->params=unserialize(file_get_contents($file));
}else{
$sql="select name, value from {$this->prename}params";
if($data=$this->getRows($sql)) foreach($data as $var){
$this->params[$var['name']]=$var['value'];
}
file_put_contents($file,serialize($this->params));
}
}
public function getPl($type=null,$played=null){
if($type==null) $type=$this->type;
if($played==null) $played=$this->$played;
$sql="select bonusProp, bonusPropBase from {$this->prename}played where id=?";
return $this->getRow($sql,$played);
}
public function getGameNo($type,$time=null){
if($time===null) $time=$this->time;
$atime=date('H:i:s',$time);
$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>? order by actionTime limit 1";
$return = $this->getRow($sql,$atime);
if(!$return){
$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit 1";
$return =$this->getRow($sql,$atime);
$time=$time+24*3600;
}
$types=$this->getTypes();
if(($fun=$types[$type]['onGetNoed']) &&method_exists($this,$fun)){
$this->$fun($return['actionNo'],$return['actionTime'],$time);
}
return $return;
}
public function getGameLastNo($type,$time=null){
if($time===null) $time=$this->time;
$atime=date('H:i:s',$time);
$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime<=? order by actionTime desc limit 1";
$return = $this->getRow($sql,$atime);
if(!$return){
$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionNo desc limit 1";
$return =$this->getRow($sql,$atime);
$time=$time-24*3600;
}
$types=$this->getTypes();
if(($fun=$types[$type]['onGetNoed']) &&method_exists($this,$fun)){
$this->$fun($return['actionNo'],$return['actionTime'],$time);
}
return $return;
}
public function getGameNos($type,$num=0,$time=null){
if($time===null) $time=$this->time;
$ptime=date('H:i:s',$time);
$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>? order by actionTime";
if($num) $sql.=" limit $num";
$return = $this->getRows($sql,$ptime);
$types=$this->getTypes();
if(($fun=$types[$type]['onGetNoed']) &&method_exists($this,$fun)){
if($return) foreach($return as $i=>$var){
$this->$fun($return[$i]['actionNo'],$return[$i]['actionTime'],$time);
$return[$i]['actionTime']=strtotime($return[$i]['actionTime']);
}
}
if(count($return)<$num){
$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit ".($num-count($return));
$return1=$this->getRows($sql);
if(($fun=$types[$type]['onGetNoed']) &&method_exists($this,$fun)){
if($return1) foreach($return1 as $i=>$var){
$this->$fun($return1[$i]['actionNo'],$return1[$i]['actionTime'],$time+24*3600);
$return1[$i]['actionTime']=strtotime($return1[$i]['actionTime']);
}
}
$return=array_merge($return,$return1);
}
return $return;
}
private function setTimeNo(&$actionTime,&$time=null){
if(!$time) $time=$this->time;
$actionTime=date('Y-m-d ',$time).$actionTime;
}
public function noHdCQSSC(&$actionNo,&$actionTime,$time=null){
$this->setTimeNo($actionTime,$time);
if($actionNo==0||$actionNo==120){
$actionNo=date('Ymd-120',$time -24*3600);
$actionTime=date('Y-m-d 00:00',$time);
}else{
$actionNo=date('Ymd-',$time).substr(1000+$actionNo,1);
}
}
public function onHdXjSsc(&$actionNo,&$actionTime,$time=null){
$this->setTimeNo($actionTime,$time);
if($actionNo>=84){
$actionNo=date('Ymd-'.$actionNo,$time -24*3600);
}else{
$actionNo=date('Ymd-',$time).substr(1000+$actionNo,1);
}
}
public function noHd(&$actionNo,&$actionTime,$time=null){
$this->setTimeNo($actionTime,$time);
$actionNo=date('Ymd-',$time).substr(100+$actionNo,1);
}
public function noxHd(&$actionNo,&$actionTime,$time=null){
$this->setTimeNo($actionTime,$time);
if($actionNo>=84){
$time-=24*3600;
}
$actionNo=date('Ymd-',$time).substr(100+$actionNo,1);
}
public function no0Hd(&$actionNo,&$actionTime,$time=null){
$this->setTimeNo($actionTime,$time);
$actionNo=date('Ymd-',$time).substr(1000+$actionNo,1);
}
public function no6Hd(&$actionNo,&$actionTime,$time=null){
$this->setTimeNo($actionTime,$time);
if($actionTime >= date('Y-m-d H:i:s',$time)){
$actionNo = date('Yz',$time)-6;
}else{
$actionNo = date('Yz',$time)-6;
$actionTime=date('Y-m-d 21:15',$time);
}
}
public function pai3(&$actionNo,&$actionTime,$time=null){
$this->setTimeNo($actionTime,$time);
if($actionTime >= date('Y-m-d H:i:s',$time)){
$actionNo = date('Yz',$time)-6;
}else{
$actionNo = date('Yz',$time)-6;
$actionTime=date('Y-m-d 18:30',$time);
}
}
public function getBonusProp($type,$playedId){
$sql="select value from {$this->prename}pl where type=? and playedId=?";
return $this->getValue($sql,array($type,$playedId));
}
public function updateSessionTime(){
$sql="update ssc_member_session set accessTime={$this->time} where id=?";
$this->update($sql,$this->user['sessionId'],$this->user['sessionId']);
}
public function checkLogin(){
if($user=unserialize($_SESSION[$this->memberSessionName])) return $user;
header('x-location: login.html');
exit('您没有登录');
}
private function setClientMessage($message,$type='Info',$showTime=3000){
$message=trim(rawurlencode($message),'"');
header("X-$type-Message: $message");
header("X-$type-Message-Times: $showTime");
}
protected function info($message,$showTime=3000){
$this->setClientMessage($message,'Info',$showTime);
}
protected function success($message,$showTime=3000){
$this->setClientMessage($message,'Success',$showTime);
}
protected function warning($message,$showTime=3000){
$this->setClientMessage($message,'Warning',$showTime);
}
public function error($message,$showTime=5000){
$this->setClientMessage($message,'Error',$showTime);
exit;
}
}
?>