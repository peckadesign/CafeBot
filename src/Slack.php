<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class Slack
{

	/**
	 * @var string
	 */
	private $webHookUrl;


	public function __construct(string $webHookUrl)
	{
		$this->webHookUrl = $webHookUrl;
	}


	public function send(string $text, string $channel, string $username, string $icon): void
	{
		$data = sprintf("payload=%s", json_encode(['channel' => $channel, 'username' => $username, 'text' => $text, 'icon_emoji' => $icon]));

		$ch = curl_init($this->webHookUrl);

		if ($ch === FALSE) {
			return;
		}

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_exec($ch);
		curl_close($ch);
	}

}
