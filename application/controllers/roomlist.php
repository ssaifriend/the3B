<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'models/room.php');
include_once(APPPATH.'models/member.php');
include_once(APPPATH.'models/result.php');

class RoomList extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->load->view('room_list');
	}

	function getRoomListToJson(){
		$start = $this->input->get('start');
		$keyword = $this->input->get('keyword');
		$type = $this->input->get('type');

		$typeReverseReplacer = array('빙고');

		$list = $this->_getRoomList($start, 15, $keyword, $type);
		for($a=0,$loopa=sizeof($list); $a<$loopa; $a++){
			$list[$a]->setGameType($typeReverseReplacer[$list[$a]->getGameType()]);
			$list[$a]->setGameOption(unserialize($list[$a]->getGameOption()));
		}
		echo json_encode($list);
	}

	function _getRoomList($start=0, $limit=15, $keyword="",$type=0){
		$this->load->model('RoomDAO');
		return $this->RoomDAO->getRoomList($start, $limit, $keyword, $type);
	}

	function doMakeRoom(){
		$name = $this->input->post('name');
		$gametype = $this->input->post('gametype');
		$gameoption = $this->input->post('gameoption');
		$maxuser = $this->input->post('maxuser');
		$private = $this->input->post('private');
		$password = $this->input->post('password');
		$roomtype = $this->input->post('roomtype');

		$room = new Room();
		$room->setName($name);
		$room->setGameType($gametype);
		$room->setGameOption($gameoption);
		$room->setMaxUser($maxuser);
		$room->setPrivate($private);
		$room->setPassword($password);
		$room->setRoomType($roomtype);
		$room->setStart(0);
		$room->setOwner($this->session->userdata('member')->getUserID());

		$this->load->model('RoomDAO');
		$result = $this->RoomDAO->makeRoom($room);
		echo $result;
	}

	function getUserInfo(){
		$data = array();
		$data['id'] = $this->session->userdata('member')->getUserID();
		$data['nickname'] = $this->session->userdata('member')->getNickname();

		$this->load->model('ResultDAO');
		$tmp = $this->ResultDAO->getResult($data['id']);
		foreach($tmp[0] as $key => $val)
			$data[$key] = (int)$val;
		echo json_encode(array($data));
	}

	function doLogout(){
		$this->session->set_userdata('member',null);
	}
}

?>