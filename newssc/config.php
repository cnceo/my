<?php
$conf['debug']['level']=5;
$conf['db']['dsn']='mysql:host=rm-wz9e37hjn83a09501o.mysql.rds.aliyuncs.com;dbname=ssc';
$conf['db']['host']='rm-wz9e37hjn83a09501o.mysql.rds.aliyuncs.com';
$conf['db']['dbname']='ssc';
$conf['db']['user']='root';
$conf['db']['password']='Show19467';
$conf['db']['charset']='utf8';
$conf['db']['prename']='ssc_';
$conf['cache']['expire']=0;
$conf['cache']['dir']='_cache/';
$conf['url_modal']=2;
$conf['action']['template']='inc/default/';
$conf['action']['modals']='action/default/';
$conf['member']['sessionTime']=15*60;
error_reporting(E_ERROR &~E_NOTICE);
ini_set('date.timezone','asia/shanghai');
?>