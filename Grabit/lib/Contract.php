<?php
class Contract {

	private $id;

	private $course;

	private $registrationDate = new DateTime();

	//WP_Userオブジェクトからプロパティをセットする
	public function __construct(WP_User $wp_user) {
		$id = $wp_user->id;
		$array = $this->getContractFromDB($wp_user->id);
		$this->setContractFromArray($array);
	}

	//連想配列からプロパティを更新する
	public function setContractFromArray($ascArray) {
		$error = [];
		foreach($result as $key => $value) {
			switch ($key) {
				case 'id':
					$this->id = $value;
					break;
				case 'course':
					$this->course = $value;
					break;
				case 'registrationDate':
					$this->registrationDate = $value
					break;
				default:
				//ここでエラーが発生する
					$error[$key] = $value
					break;
			}
		}
	}

	//WP_Userオブジェクトの$idから、DBの情報を連想配列で返す
	private static function getContractFromDB($id) {
		global $wpdb;
		$rawdata = $wpdb->get_row($wpdb->prepare(
		 "SELECT * FROM $wpdb->my_Contract WHERE id = %d", $id),
		 ARRAY_A
		);
		if($rawdata === null) {
			//ここでエラーが発生する
		} else {
			return $rawdata;
		}
	}

	//インスタンスのプロバティを返す
	public function getId() {
		return $this->id;
	}

	public function getCourse() {
		return $this->course;
	}

	public function getRegistrationDate() {
		return $this->registrationDate;
	}


}