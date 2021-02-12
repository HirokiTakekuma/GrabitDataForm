<?php
class PreRegisterDB extends PreRegister {

	public static $rawdata;

	public static $result;

	public static function checkArray(array $rawdata_row) :bool {
		$properties = get_class_vars(get_parent_class(__CLASS__));
		foreach($properties as $key => $value) {
			if (!array_key_exists($key, $rawdata_row)) {
				return False;
			}
		}
		return True;
	}


	public static function checkDuplicates() :bool {
		global $wpdb;
		self::$rawdata = [];

		//use email to import $rawdata from DB

		self::$rawdata['registered'] = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM $wpdb->my_guardians WHERE email = %s", self::$email),
			 ARRAY_A
			);

		self::$rawdata['preregistered'] = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM $wpdb->my_preregister WHERE email = %s", self::$email),
			ARRAY_A
		);

		var_dump(self::$rawdata);

		if ( self::$rawdata['registered'] === [] ) {
			if (self::$rawdata['preregistered'] === [] ) {
				return True;
			} else {
				return True;
			}
		} else {
			if ( array_key_exists("id", self::$rawdata['preregistered']) ) {
				var_dump(self::$rawdata['preregistered']['authentication']);
				return self::$rawdata['preregistered']['authentication'] === 0;
			} elseif ( self::$rawdata['preregistered'] ) {
				for ($i = 0, $len = count(self::$rawdata['preregistered']); $i<$len; $i++) {
					if (self::$rawdata['preregistered'][i]['authentication'] === 1) {
						return False;
					}
				}
				return True;
			}
		}

	}

	public static function setDB() :bool {

		if ( !self::checkProperties() ) {
			throw new Exception('プロパティが不足しています');
			return False;
		}

		if ( !self::checkDuplicates() ) {
			throw new Exception('すでに登録済みのメールアドレスです');
			return False;
		}

		global $wpdb;
		self::$result = $wpdb->insert(
			"$wpdb->my_preregister",
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

		if (self::$result === 1) {
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

	}

	public static function getDB(string $hash) :bool {

		global $wpdb;
		self::$rawdata = $wpdb->get_results( $wpdb->prepare(
		 "SELECT * FROM $wpdb->my_preregister WHERE hash = %s AND date > (NOW() - INTERVAL 1 DAY)", $hash),
		 ARRAY_A
		);

		if ( !self::$rawdata ) {
			throw new Exception('データが見つかりませんでした。');
			echo "データが参照できませんでした。";
			return False;
		} else {
			var_dump(self::$rawdata);
			if (array_key_exists('id', self::$rawdata)) {
				return self::setProperties(self::$rawdata);
			} elseif (is_array(self::$rawdata)) {
				for ($i=0, $len=count(self::$rawdata); $i<$len ;$i++) {
					if (self::checkArray(self::$rawdata[$i])) {
						return self::setProperties(self::$rawdata[$i]);
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

	public static function updateDB() {

		global $wpdb;
		self::$result = $wpdb->update(
			"$wpdb->my_preregister",
			array(
				'authentication' => self::$authentication,
			),
			array(
				'course' => self::$course,
				'phone' => self::$phone,
				'email' => self::$email,
				'user_pass' => self::$user_pass,
				'hash' => self::$hash,
				'paid' => self::$paid,
			)
		);

		if(self::$result === False) {
			throw new Exception('DBに登録できませんでした');
			return False;
		} else {
			return True;
		}
	}

}