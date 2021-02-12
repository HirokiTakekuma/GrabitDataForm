<?php
class PreRegisterForm extends PreRegister {

	public static $kies = [
		'course',
		'phone',
		'email',
		'user_pass',
	];

	//セットする値の検証をする
	static function setPropeties(string $key, $value) :bool{
		switch ($key) {
			case 'course' :
				return self::setCourse($value);
				break;				

			case 'phone':
				return self::setPhone($value);
				break;

			case 'email':
				return self::setEmail($value);
				break;

			case 'user_pass':
				return self::setUser_pass($value);
				break;

			default :
				return False;
		}
	}
}