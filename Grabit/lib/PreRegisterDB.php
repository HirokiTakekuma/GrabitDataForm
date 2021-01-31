<?php
namespace Grabit;

class PreRegisterDB extends PreRegister {

	public static $errors;

	public static $result;

	public static $rawdata;

	public static function checkRawdata() :bool {

	}


//dont duplicate=> True, duplicate => False
	public static function duplicateCheck() :bool {
		global $wpdb;
		self::$rawdata = [];

		//use id & email to import $rawdata from DB

		self::$rawdata[] = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM $wpdb->contracts WHERE id = %s OR email = %s", self::login_id, self::email),
			 ARRAY_A
			);

		self::$rawdata[] = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM $wpdb->preregister WHERE id = %s OR email = %s", self::login_id, self::email),
			ARRAY_A
		);

		if ( self::$rawdata[0] ) {
			return False;
		} else {
			if ( array_key_exists("login_id", self::$rawdata[1]) ) {
				return self::$rawdata[1]['authentication'] === 0;
			} elseif ( self::$rawdata[1] ) {
				for ($i = 0, $len = count(self::$rawdata[1]); $i<$len; $i++) {
					if (self::$rawdata[1][i]['authentication'] === 1) {
						return False;
					}
				return True;
				}
			}
		}

	}

	public static function setDB() :bool {

		if ( self::checkProperties() ) {
			global $wpdb;
			self::$result = $wpdb->insert(
				'my_preregister',
				array(
					'course' => self::$course,
					'login_id' => self::$login_id,
					'login_pw' => self::$login_pw,
					'name' => self::$name,
					'name_yomigana' => self::$name_yomigana,
					'phone' => self::$phone,
					'email' => self::$email,
					'address' => self::$address,
					'hash' => self::$hash,
				),
			);

			if (self::$result === '1') {
				return True;
			} elseif  (self::$result === false) {
				echo '登録に失敗しました';
				echo "エラー：{$e->show_errors()}";
				echo 'もう一度<a href="'.home_url().'">こちら</a>から登録申請をお願いします。';
				return False;
			} else {
				echo '予期せぬエラーが起きました';
				echo 'もう一度登録作業を行ってください';
				return False;
			}

		} else {
			echo 'データに誤りがあります。';
			return False;
		}
	}

	public static function getDB(string $hash) :bool {

		global $wpdb;
		self::$rawdata = $wpdb->get_results( $wpdb->prepare(
		 "SELECT * FROM $wpdb->my_preregister WHERE email = %s AND hash = %s AND date > (NOW() - INTERVAL 1 DAY)", self::email, self::hash),
		 ARRAY_A
		);

		if ( !self::$rawdata ) {
			throw new Exception('データが見つかりませんでした。');
			echo "データが参照できませんでした。";
			return False;
		} else {
			if (array_key_exists('course', self::$rawdata)) {
				if(self::setProperties(self::$rawdata)) {
					return True;
				} else {
					return False;
				}
			} elseif (is_array(self::$rawdata)) {
				for ($i=0, $len=count(self::$rawdata); $i<$len ;$i++) {
					if (self::checkArray($rawdata[$i])) {
						return self::setProperties($rawdata[$i]);
					}
				}
				throw new Exception('登録したデータに不備がありました。');
				echo 'もう一度登録フォームから登録作業を行ってください。';
				return False;
			} else {
				throw new Exeption ('データベース破損エラー。');
				echo 'お手数ですが、もう一度登録フォームから登録作業を行ってください';
				return False;
			}
		}
	}

}