<?php
class Report extends WebLoginBase{
	public $type;
	public $pageSize=20;
	
	// �ʱ��б�
	public final function coin($type=0){
		$this->type=$type;
		$this->action='coinlog';
		$this->display('report/coin.php');
	}
	
	public final function coinlog($type=0){
		$this->type=$type;
		$this->display('report/coin-log.php');
	}
	
	public final function fcoinModal(){
		$this->display('report/fcoin-log.php');
	}
	
	// �����ܶ�
	public final function fanDian(){
		$this->display('report/fan-dian.php');
	}
	
	// ׯ��ׯ�����ѯ
	public final function znz(){
		$this->display('report/znz.php');
	}
	
	// ϵͳ�����ѯ
	public final function sys(){
		$this->display('report/sys.php');
	}
	
	// �ܽ����ѯ
	public final function count(){
		$this->display('report/count.php');
	}
	
	public final function countSearch(){
		$this->display('report/count-list.php');
	}
}
