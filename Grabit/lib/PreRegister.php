<?php
class PreRegister {

	public static $course;

	public static $phone;

	public static $email;

	public static $user_pass;

	public static $hash;

	public static $authentication = 0;

	public static $paid = 0;


	public static function setCourse(string $course):bool {

		if (in_array($course, ['質問回答','内部コンテンツ',], true)) {
			self::$course = $course;
			return True;
		} else {
			throw new Exception('正しいコースを選択してください。');
			return False;
		}
	}	

	public static function setPhone(string $phone):bool {
		if(preg_match("/^[0-9]+$/", $phone)) {
			self::$phone = $phone;
			return True;
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

	public static function setUser_pass(string $user_pass):bool {
		if (preg_match("/^[a-zA-Z0-9]+$/", $user_pass) && strlen($user_pass) > 8) {
			self::$user_pass = $user_pass;
			return True;
		} else {
			throw new Exception('pwは8文字以上の半角英数で入力してください。');
			return False;
		}
	}

	public static function setHash(string $hash) {
		self::$hash = $hash;
	}

	public static function setAuthentication(string $authentication) {
		self::$authentication = $authentication;
	}

	public static function setPaid(string $paid) {
		self::$paid = $paid;
	}


	public static function makeHash() {
		$seed = uniqid('honnedechujuservicehasaikou');
		self::$hash = hash('sha256', $seed);
	}

	public static function getUrlToken() {
		$preregistered_url = home_url('/preregistered/');
		$url = $preregistered_url .'?my_authentication=false'.'?url_token='.self::$hash;
		return $url;
	}

	public static function checkProperties() {
		$array = get_class_vars(__CLASS__);
		var_dump($array);
		foreach ($array as $key => $value) {
			if ($value === null) {
				echo $key;
				return false;
			}
		}
		return true;
	}

	public static function setProperties(array $array) {
		if (array_key_exists('course', $array)) {
			foreach ($array as $key => $value) {
				var_dump($key);
				switch ($key) {
					case 'id' :
						break;
					case 'course' :
						self::setCourse($value);
						break;
					case 'date' :
						break;
					case 'phone' :
						self::setPhone($value);
						break;
					case 'email' :
						self::setEmail($value);
						break;
					case 'user_pass' :
						self::setUser_pass($value);
						break;
					case 'hash' :
						self::setHash($value);
						break;
					case 'authentication' :
						self::setAuthentication($value);
						break;
					case 'paid' :
						self::setPaid($value);
						break;
					default :
						return False;
				}
			}
			return True;
		} else {
			return False;
		}
	}


}