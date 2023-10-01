<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_team(){
		$_POST['members'] = addslashes(htmlspecialchars($_POST['members']));
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `team_list` where `code` = '{$code}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Team Code already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `team_list` set {$data} ";
		}else{
			$sql = "UPDATE `team_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$aid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['aid'] = $aid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Team successfully saved.";
			else
				$resp['msg'] = " Team successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_team(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `team_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Team successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_request(){
		if(isset($_POST['message']))
		$_POST['message'] = addslashes(htmlspecialchars($_POST['message']));
		
		if(isset($_POST['location']))
		$_POST['location'] = addslashes(htmlspecialchars($_POST['location']));

		if(empty($_POST['id'])){
			$pref = date("Ymd");
			$code = sprintf("%'.05d", 1);
			while(true){
				$check = $this->conn->query("SELECT id FROM `request_list` where `code` = '{$pref}{$code}'")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d", abs($code) + 1);
				}else{
					$_POST['code'] = $pref.$code;
					break;
				}
			}
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `request_list` set {$data} ";
		}else{
			$sql = "UPDATE `request_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$tid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['tid'] = $tid;
			$resp['status'] = 'success';
			if(empty($id)){
				$this->settings->set_flashdata('request_sent', "Your report has been sent successfully. Your request code id: <b>{$code}</b>");
			}else{
				$resp['msg'] = " request successfully updated.";
				$this->settings->set_flashdata('success', "Request has been updated successfully.");
			}

		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
	
			return json_encode($resp);
	}
	function delete_request(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `request_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Request successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function assign_team(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `request_list` set `status`  = 1, team_id = '{$team_id}' where id = '{$id}'");
		if($update){
			$history = $this->conn->query("INSERT INTO `history_list` set `request_id` ='{$id}', `status` = 1, `remarks` = 'Request has been assign to a fire control team.' ");
			if($history){
				$this->settings->set_flashdata("success", 'Request has been assign to a team.');
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function take_action(){
		extract($_POST);
		$remarks = addslashes(htmlspecialchars($remarks));
		$update = $this->conn->query("UPDATE `request_list` set `status`  = {$status} where id = '{$id}'");
		if($update){
			$history = $this->conn->query("INSERT INTO `history_list` set `request_id` ='{$id}', `status` = {$status}, `remarks` = '{$remarks}' ");
			if($history){
				$this->settings->set_flashdata("success", 'Request\'s Status has been updated successfully.');
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_inquiry(){
		$_POST['message'] = addslashes(htmlspecialchars($_POST['message']));
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `inquiry_list` set {$data} ";
		}else{
			$sql = "UPDATE `inquiry_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success'," Your Inquiry has been sent successfully. Thank you!");
			else
				$this->settings->set_flashdata('success'," Inquiry successfully updated");
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_inquiry(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inquiry_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Inquiry has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_team':
		echo $Master->save_team();
	break;
	case 'delete_team':
		echo $Master->delete_team();
	break;
	case 'save_request':
		echo $Master->save_request();
	break;
	case 'delete_request':
		echo $Master->delete_request();
	break;
	case 'assign_team':
		echo $Master->assign_team();
	break;
	case 'take_action':
		echo $Master->take_action();
	break;
	case 'save_inquiry':
		echo $Master->save_inquiry();
	break;
	case 'delete_inquiry':
		echo $Master->delete_inquiry();
	break;
	default:
		// echo $sysset->index();
		break;
}