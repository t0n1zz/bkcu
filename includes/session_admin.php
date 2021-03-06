<?php
class session {

	private $logged_in = false;
	public $user_id;
	public $pesan;

	function __construct(){
		session_start();
		$this->cek_login();
		$this->cek_pesan();
	}
	
	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function login($user){
		if($user){
			$this->user_id = $_SESSION['bkcu_user'] = $user->id;
			$this->logged_in = true;
		}
	}
	
	public function logout(){
		unset($_SESSION['bkcu_user']);
		unset($this->user_id);
		$this->logged_in = false;
	}
	
	public function pesan($msg=""){
		if(!empty($msg)){
			$_SESSION['pesan'] = $msg;
		}else{
			return $this->pesan;
		}
	}
		
	private function cek_pesan(){
		if(isset($_SESSION['pesan'])){
			$this->pesan = $_SESSION['pesan'];
			unset($_SESSION['pesan']);
		}else{
			$this->pesan = "";
		}
	}
	

	
	private function cek_login(){
		if(isset($_SESSION['bkcu_user'])){
			$this->user_id = $_SESSION['bkcu_user'];
			$this->logged_in = true;
		}else{
			unset($this->user_id);
			$this->logged_in = false;
		}
	}
}

$session = new session();
$pesan = $session->pesan();
?>