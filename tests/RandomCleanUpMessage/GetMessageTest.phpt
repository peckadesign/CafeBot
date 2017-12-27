<?php declare(strict_types = 1);

namespace PdTests\CafeBot\Bot;

include __DIR__ . '/../../vendor/autoload.php';

final class GetMessageTest extends \Tester\TestCase
{

	public function testGetMessage(): void
	{
		$provider = new \Pd\CafeBot\RandomCleanUpMessage();

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

}

(new GetMessageTest())->run();
