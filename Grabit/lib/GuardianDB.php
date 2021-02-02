<?php
class GuardianDB extends Guardian {

//WP_User オブジェクト
	private $wp_user;

	private $rawdata;

	private $rawdata_contract;

	function __construct() {
		$current_user = wp_get_current_user();
		if( $current_user->exists() ) {
			$this->wp_user = $current_user;
			if( isset($current_user->ID) ) {
				$this->wp_id = $current_user->ID;
			} else {
				throw new Exception('無効なユーザーです。');
			}
		} else {
			throw new Exception('無効なユーザーです。');
		}
	}

	function setGuardian() {
		global $wpdb;
		$this->rawdata = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM {$wpdb->prefix}my_Guardians WHERE id = %s", $this->wp_id),
			ARRAY_A
		);
		if (!$this->rawdata) {
			throw new Exception('Guardinユーザー情報が存在しません。');
			return False;
		}

		foreach ($this->rawdata as $key => $value) {
			switch ($key) {
				case 'id' :
					$this->setId($value);
				case 'wp_id' :
					$this->setWp_id($value);
				case 'pw' :
					$this->setPw($value);
				case 'first_name' :
					$this->setFirset_name($value);
				case 'last_name' :
					$this->setLast_name($value);
				case 'first_name_yomigana' :
					$this->setFirst_name_yomigana($value);
				case 'last_name_yomigana' :
					$this->setLast_name_yomigana($value);
				case 'phone':
					$this->setPhone($value);
				case 'email':
					$this->setEmail($value);
				default :
					throw new Exception('Gurdianデーブルに無いcolが参照されました');
					return False;
			}

		global $wpdb;
		$this->rawdata_contract = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM {$wpdb->prefix}my_contracts WHERE guardian_id = %s", $this->id),
			ARRAY_A
		);
		if ($this->rawdata_contract) {
			throw new Exception('Contractユーザー情報が存在しません');
			return False;
		}
  
		$contract = new Contract();
		$contract->setData($this->rawdata_contract);
		if( $this->setContract($contract); ) {
			return True;
		} else {
			return False;
		}
	}
}