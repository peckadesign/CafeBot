<?php declare(strict_types = 1);

namespace PdTests\CafeBot\Bot;

include __DIR__ . '/../../vendor/autoload.php';

final class GetMessageTest extends \Tester\TestCase
{

	public function testManyMessage(): void
	{
		$messages = [
			'qwertz',
			'asdfgh',
			'yxcvb',
		];

		$provider = new \Pd\CafeBot\RandomCleanUpMessage($messages);

		\Tester\Assert::type('string', $provider->getMessage());

		$message = $provider->getMessage();
		$wasChange = FALSE;
		for ($i = 0; $i < 10; $i++) {
			if ($message !== $provider->getMessage()) {
				$wasChange = TRUE;
				break;
			}
		}
		\Tester\Assert::true($wasChange, 'Náhodný generátor vracel pouze jednu stejnou zprávu: ' . $message);
	}


	public function testOneMessage(): void
	{
		$messages = [
			'qwertz',
		];

		$provider = new \Pd\CafeBot\RandomCleanUpMessage($messages);

		\Tester\Assert::type('string', $provider->getMessage());

		$message = $provider->getMessage();
		for ($i = 0; $i < 10; $i++) {
			if ($message !== $provider->getMessage()) {
				\Tester\Assert::fail('Nedošlo ke vrácení stále stejné jedné zprávy');
			}
		}
		\Tester\Assert::true(TRUE, 'Náhodný generátor vracel pouze jednu stejnou zprávu: ' . $message);
	}

}

(new GetMessageTest())->run();
