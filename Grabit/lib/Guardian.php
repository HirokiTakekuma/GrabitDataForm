<?php
class Guardian {
//Guardian table上の番号
	private $id;
//WP_Userオブジェクトのid
	private $wp_id;

	private $user_name;

	private $user_pass;

	private $first_name;

	private $last_name;

	private $first_name_yomigana;

	private $last_name_yomigana;

	private $phone;

	private $email;

	private $contracts = [];

	public function setId(string $id) {
		if (preg_match("/^[a-zA-Z0-9]+$/", $id)) {
			$this->id = $id;
			return True;
		} else {
			throw new Exception('id');
			return False;
		}
	}

	public function setPw(string $pw) {
		if (preg_match("/^[a-zA-Z0-9]+$/", $login_id) && strlen($login_id) > 8) {
			$this->pw = $pw;
			return True;
		} else {
			throw new Exception('pw');
			return False;
		}
	}

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

	public function setPhone(string $phone):bool {
		if(preg_match("/^[0-9]+$/", $phone)) {
			return True;
			$this->phone = $phone;
		} else {
			throw new Exception('電話番号は数字で入力してください。');
			return False;
		}
	}

	public function setEmail(string $email):bool {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->email = $email;
			return True;
		} else {
			throw new Exception('メールアドレスを正しく入力してください。');
			return False;
		}
	}

	public function setContracts(Contract $contract) {
		if($this->id === $contract->guardian_id) {
			$this->contracts[] = $contract;
			return True;
		} else {
			throw new Exception('Contract_id does not match');
			return False;
		}
	}

	public function getId() {
		return $this->id;
	}

	public function getPw() {
		return $this->pw;
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

	public function getPhone() {
		return $this->phone;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getContract() {
		return $this->contract;
	}

	public function getInformation() {
		return (array)$this;
	}
}