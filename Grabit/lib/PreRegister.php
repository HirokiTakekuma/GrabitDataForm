<?php

namespace Grabit;

class PreRegister {

	public static $course;

	public static $login_id;

	public static $login_pw;

	public static $first_name;

	public static $last_name;

	public static $first_name_yomigana;

	public static $last_name_yomigana;

	public static $phone;

	public static $email;

	public static $address_prefecture;

	public static $address_municipalitiy;

	public static $hash;

	public static $authentication = 0;

	public static $paid = 0;

	public static function getCourse() {
		return self::$course;
	}

	public static function getLogin_id() {
		return self::$login_id;
	}

	public static function getLogin_pw() {
		return self::$login_pw;
	}

	public static function getFirst_name() {
		return self::$first_name;
	}

	public static function getLast_name() {
		return self::$last_name;
	}

	public static function getFirst_name_yomigana() {
		return self::$first_name_yomigana;
	}

	public static function getLast_name_yomigana() {
		return self::$last_name_yomigana;
	}

	public static function getPhone() {
		return self::$phone;
	}

	public static function getEmail() {
		return self::$email;
	}

	public static function getAddress_prefecture() {
		return self::$address_prefecture;
	}

	public static function getAddress_municipality() {
		return self::$address_municipality;
	}


	public static function setCourse(string $course):bool {

		if (in_array($course, ['質問回答','内部コンテンツ',], true)) {
			self::$course = $course;
			return True;
		} else {
			throw new Exception('正しいコースを選択してください。');
			return False;
		}
	}	

	public static function setLogin_id(string $login_id):bool {
		if (preg_match("/^[a-zA-Z0-9]+$/", $login_id) && strlen($login_id) > 6) {
			self::$login_id = $login_id;
			return True;
		} else {
			throw new Exception('idは６文字以上の半角英数字で入力してください。');
			return False;
		}
	}

	public static function setLogin_pw(string $login_pw):bool {
		if (preg_match("/^[a-zA-Z0-9]+$/", $login_pw) && strlen($login_pw) > 8) {
			self::$login_pw = $login_pw;
			return True;
		} else {
			throw new Exception('pwは8文字以上の半角英数で入力してください。');
			return False;
		}
	}

	public static function setFirst_name(string $name):bool {

		if (preg_match("/^[ぁ-んァ-ン一-龠]+$/u", $name)) {
			self::$first_name = $name;
			return True;
		} else {
			throw new Exeption('名前は日本語で入力してください。');
			return False;
		}
	}

	public static function setLast_name(string $name):bool {

		if (preg_match("/^[ぁ-んァ-ン一-龠]+$/u", $name)) {
			self::$last_name = $name;
			return True;
		} else {
			throw new Exeption('名前は日本語で入力してください。');
			return False;
		}
	}

	public static function setFirst_name_yomigana(string $name_yomigana):bool {

		if(preg_match("/^[ァ-ン]+$/u", $name_yomigana)) {
			self::$first_name_yomigana = $name_yomigana;
			return True;
		} else {
			throw new Exception('読み仮名はカタカナで入力してください。');
			return False;
		}
	}

	public static function setLast_name_yomigana(string $name_yomigana):bool {

		if(preg_match("/^[ァ-ン]+$/u", $name_yomigana)) {
			self::$last_name_yomigana = $name_yomigana;
			return True;
		} else {
			throw new Exception('読み仮名はカタカナで入力してください。');
			return False;
		}
	}	

	public static function setPhone(string $phone):bool {
		if(preg_match("/^[0-9]+$/", $phone)) {
			return True;
			self::$phone = $phone;
		} else {
			throw new Exception('電話番号は数字で入力してください。');
			return False;
		}
	}

	public static function setEmail(string $email):bool {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			self::$email = $email;
			return True;
		} else {
			throw new Exception('メールアドレスを正しく入力してください。');
			return False;
		}
	}


	public static function setAddress_prefecture(string $prefecture):bool {
		$prefectures = [
			'北海道',
			'青森県',
			'岩手県',
			'宮城県',
			'秋田県',
			'山形県',
			'福島県',
			'茨城県',
			'栃木県',
			'群馬県',
			'埼玉県',
			'千葉県',
			'東京都',
			'神奈川県',
			'新潟県',
			'富山県',
			'石川県',
			'福井県',
			'山梨県',
			'長野県',
			'岐阜県',
			'静岡県',
			'愛知県',
			'三重県',
			'滋賀県',
			'京都府',
			'大阪府',
			'兵庫県',
			'奈良県',
			'和歌山県',
			'鳥取県',
			'島根県',
			'岡山県',
			'広島県',
			'山口県',
			'徳島県',
			'香川県',
			'愛媛県',
			'高知県',
			'福岡県',
			'佐賀県',
			'長崎県',
			'熊本県',
			'大分県',
			'宮崎県',
			'鹿児島県',
			'沖縄県',];
		if (in_array($prefecture, $prefectures, true)){
			self::$address_prefecture = $prefecture;
			return True;
		} else {
			throw new Exception('そのような県はありません');
			return False;
		}
	}

	public static function setAddress_municipality(string $municipality) {
		if (preg_match("/^[ぁ-んァ-ン一-龠]+$/u",$municipality)) {
			self::$address_municipality = $municipality;
			return True;
		} else {
			throw new Exception('日本語で入力してください');
			return False;
		}
	}

	public static function makeHash() {
		$seed = uniqid('honnedechujuservicehasaikou');
		self::$hash = hash('sha256', $seed);
	}

	public static function getUrlToken() {

		$preregistered_url = home_url('/preregister/');
		$url = $preregistered_url .'?url_token='.self::$hash;
		return $url;
	}

	public static function checkProperties() {
		foreach (self as $key => $value) {
			if (!$value) {
				return false;
				break;
			}
		}
		return true;
	}




}