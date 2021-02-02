<?php

namespace Grabit;

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

	public static function setUser_pass(string $user_pass):bool {
		if (preg_match("/^[a-zA-Z0-9]+$/", $user_pass) && strlen($user_pass) > 8) {
			self::$user_pass = $user_pass;
			return True;
		} else {
			throw new Exception('pwは8文字以上の半角英数で入力してください。');
			return False;
		}
	}

	public function setHash(string $hash) {
		self::$hash = $hash;
	}


	public static function nakeHash() {
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
			if (!isset($value)) {
				return false;
			}
		}
		return true;
	}

	public static function setProperties(array $array) {
		if (array_key_exists('course', $array)) {
			foreach ($array as $key => $value) {
				switch ($key) {
					case 'course' :
						self::setCourse($value);
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