<?php
class Student {

	private $id;

	private $first_name;

	private $last_name;

	private $first_name_yomigana;

	private $last_name_yomigana

	private $birth_date;

	private $grade;

	private $gender;

	private $cram;

	private $score;

	private $note;

	public function setFirst_name(string $name):bool {

		if (preg_match("/^[ぁ-んァ-ン一-龠]+$/u", $name)) {
			$this->first_name = $name;
			return True;
		} else {
			throw new Exeption('名前は日本語で入力してください。');
			return False;
		}
	}

	public function setLast_name(string $name):bool {

		if (preg_match("/^[ぁ-んァ-ン一-龠]+$/u", $name)) {
			$this->last_name = $name;
			return True;
		} else {
			throw new Exeption('名前は日本語で入力してください。');
			return False;
		}
	}

	public function setFirst_name_yomigana(string $name_yomigana):bool {

		if(preg_match("/^[ァ-ン]+$/u", $name_yomigana)) {
			$this->first_name_yomigana = $name_yomigana;
			return True;
		} else {
			throw new Exception('読み仮名はカタカナで入力してください。');
			return False;
		}
	}

	public function setLast_name_yomigana(string $name_yomigana):bool {

		if(preg_match("/^[ァ-ン]+$/u", $name_yomigana)) {
			$this->last_name_yomigana = $name_yomigana;
			return True;
		} else {
			throw new Exception('読み仮名はカタカナで入力してください。');
			return False;
		}
	}

	public function setBirth_date(DateTime $birth_date) {
		$now = new DateTime();
		if ($now > $birth_date) {
			$this->birth_date = $birth_date;
			return True;
		} else {
			return False;
		}
	}

	public function setGrade(int $grade) {
		if ((is_int($grade))&&(1=<$grade=<6)){
			$this->grade = $grade;
			return True;
		} else {
			return False;
		}
	}

	public function setGender(int $gender) {
		if ((is_int($grade))&&(is_array($gender,[0,1,2,9]))){
			$this->gender = $gender;
			return True;
		} else {
			return False;
		}
	}

	public function setCram(string $cram) {
		$this->cram = $cram;
		return True;
	}

	public function setScore(int $score) {
		if (in_array($score, [1,2,3,4,5])) {
			$this->score = $score;
			return True;
		} else {
			return False;
		}
	}

	public function setNote(string $note) {
		$this->note = $note;
		return True;
	}

	public function getFirst_name() {
		return $this->first_name;
	}

	public function getLast_name() {
		return $this->last_name;
	}

	public function getFirst_name_yomigana() {
		return $this->first_name_yomigana;
	}

	public function getLast_name_yomigana() {
		return $this->last_name_yomigana;
	}

	public function getBirth_date() {
		return $this->birth_date;
	}

	public function getGrade() {
		return $this->grade;
	}

	public function getGender() {
		return $this->gender;
	}

	public function getCram() {
		return $this->cram;
	}

	public function getScore() {
		return $this->score;
	}
	
	public function getNote() {
		return $this->note;
	}

	public function getInformation() {
		return (array)$this;
	}
}