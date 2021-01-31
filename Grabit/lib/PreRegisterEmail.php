<?php
namespace Grabit;

class PreRegisterEmail extends PreRegister {

	public static function sendEmail() {
		//メール本文で使う文字列
		$name = self::name;
		$course = self::course;
		$url = self::getUrlToken;
		//メールの構成情報を設定する
		$to = self::$email ;
		$subject = '【ホンネで中学受験サービス】：メールアドレス確認のお知らせ';
		$body = <<<EOD
		{$name}様
		今回はホンネで中学受験のサービスにご応募いただきありがとうございます。
		本サービスでは、このメールアドレスに領収書などの重要なお知らせをお送りいたしますので、
		こまめに確認していただきますよう深くお願いいたします。
		以降の決済登録は<a href = {$url}>こちら</a>からお願いします。
		EOD;
		$headers = '';

		if (mb_send_mail($to, $subject, $body, $headers)) {
			//メールを送信できた
			return True;
		} else {
			//メールを送信できなかった
			return False;
		}
	}

}