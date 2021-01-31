<?php
namespace Grabit;

class PreRegisterForm extends PreRegister {

	public static $kies = [
		'course',
		'login_id',
		'login_pw',
		'name',
		'name_yomigana',
		'phone',
		'email',
		'address',
	];

	//セットする値の検証をする
	static function setPropeties(string $key, $value) :bool{
		switch ($key) {
			case 'course' :
				return self::setCourse($value);
				break;				

			case 'login_id' :
				return self::setLogin_id($value);
				break;

			case 'login_pw' :
				return self::setLogin_pw($value);
				break;

			case 'first_name':
				return self::setFirstname($value);
				break;

			case 'last_name':
				return self::setLastname($value);
				break;

			case 'first_name_yomigana':
				return self::setFirst_name_yomigana($value);
				break;

			case 'last_name_yomigana':
				return self::setLast_name_yomigana($value);
				break;


			case 'phone':
				return self::setPhone($value);
				break;

			case 'email':
				return self::setEmail($value);
				break;

			case 'address_prefecture':
				return self::setAddress_prefecture($value);
				break;

			case 'address_municipality':
				return self::setAddress_municipality($value);
				break;

			case 'hash':
				return self::setHash($value);
				break;

			default :
				return False;
		}
	}
}