<?php
namespace Grabit;

class PreRegisterDB extends PreRegister {

	public static $rawdata;

	public static function checkRawdata() :bool {

	}


	public static function duplicateCheck() :bool {
		global $wpdb;
		self::$rawdata = [];

		//use email to import $rawdata from DB

		self::$rawdata['guardian'] = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM $wpdb->my_guardian WHERE email = %s", self::email),
			 ARRAY_A
			);

		self::$rawdata['preregister'] = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM $wpdb->my_preregister WHERE email = %s", self::email),
			ARRAY_A
		);

		if ( self::$rawdata['guardian'] ) {
			return False;
		} else {
			if ( array_key_exists("id", self::$rawdata['preregister']) ) {
				return self::$rawdata['preregister']['authentication'] === 0;
			} elseif ( self::$rawdata['preregister'] ) {
				for ($i = 0, $len = count(self::$rawdata['preregister']); $i<$len; $i++) {
					if (self::$rawdata['preregister'][i]['authentication'] === 1) {
						return False;
					}
				}
				return True;
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
					'phone' => self::$phone,
					'email' => self::$email,
					'user_pass' => self::$user_pass,
					'hash' => self::$hash,
					'authentication' => self::$authentication,
					'paid' => self::$paid,
				),
			);

			if (self::$result === '1') {
				return True;
			} elseif  (self::$result === false) {
				echo '登録に失敗しました';
				echo "エラー：{$e->show_errors()}";
				echo 'もう一度<a href="'.esc_url(home_url('/preregister')).'">こちら</a>から登録申請をお願いします。';
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
		 "SELECT * FROM $wpdb->my_preregister WHERE email = %s AND hash = %s AND date > (NOW() - INTERVAL 1 DAY)", self::$email, self::$hash),
		 ARRAY_A
		);

		if ( !self::$rawdata ) {
			throw new Exception('データが見つかりませんでした。');
			echo "データが参照できませんでした。";
			return False;
		} else {
			if (array_key_exists('course', self::$rawdata)) {
				return self::setProperties(self::$rawdata);
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