<?php
class Contract {

	private $id

	private $course;

	private $timestamp = new DateTime();

	private $student_id;

	private $guardian_id;

	public function setCourse(string $course) {
		$courses = ['質問回答','内部コンテンツ',];
		if (in_array($course, $courses)) {
			$this->course = $course;
			return True;
		} else {
			throw new Exception('Contractの$courseプロパティ');
		}
	}

	public function setTimestamp(DateTime $timestamp) {
		$sevice_start = new DateTime();
		$service_start->setDate(2020, 8, 1);
		if ($timestamp > $service_start) {
			$this->timestamp = $timestamp;
			return True;
		} else {
			throw new Exception('Contractの$timestampプロパティ');
			return False;
		}
	}

	public function setLogin_id(string $login_id) {
		if (preg_match("/^[a-zA-Z0-9]+$/", $login_id) && strlen($login_id) > 6) {
			$this->login_id = $login_id;
			return True;
		} else {
			throw new Exception('Contractの$login_idプロパティ');
			return False;
		}
	}

	public function setLogin_pw(string $login_pw) {
		if(preg_match("/^[a-zA-Z0-9]+$/", $login_id) && strlen($login_id) > 8) {
			$this->login_pw = $login_pw;
			return True;
		} else {
			throw new Exception('Contractの$login_pwプロパティ');
			return False;
		}
	}





}