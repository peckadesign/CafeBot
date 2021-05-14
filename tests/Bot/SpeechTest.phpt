<?php declare(strict_types = 1);

namespace PdTests\CafeBot\Bot;

include __DIR__ . '/../../vendor/autoload.php';

final class SpeechTest extends \Tester\TestCase
{

	public function testSpeechWithoutCleaner(): void
	{
		$messageProvider = new class implements \Pd\CafeBot\IMessageProvider
		{

			public function getMessage(): string
			{
				return 'Vyčistit';
			}

		};

		$cleanerProvider = new class implements \Pd\CafeBot\ICleanerProvider
		{

			public function getCleaner(): ?string
			{
				\Tester\Assert::fail('Uklizeč není potřeba');
			}


			public function getNextCleaner(): ?string
			{
				\Tester\Assert::fail('Metoda není implementována');
			}
		};

		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider
		{

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2018-08-23');
			}

		};

		$bot = new \Pd\CafeBot\Bot($messageProvider, $cleanerProvider, $dateTimeProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit', $message);
	}


	public function testSpeechOnFriday(): void
	{
		$messageProvider = new class implements \Pd\CafeBot\IMessageProvider
		{

			public function getMessage(): string
			{
				return 'Vyčistit.';
			}
		};

		$bot = new \Pd\CafeBot\Bot($messageProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit.', $message);
	}

}

(new SpeechTest())->run();
