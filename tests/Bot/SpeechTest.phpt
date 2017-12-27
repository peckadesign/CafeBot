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

		};

		$bot = new \Pd\CafeBot\Bot($messageProvider, $cleanerProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit', $message);
	}


	public function testSpeechWithName(): void
	{
		$messageProvider = new class implements \Pd\CafeBot\IMessageProvider
		{

			public function getMessage(): string
			{
				return 'Vyčistit %s';
			}
		};

		$cleanerProvider = new class implements \Pd\CafeBot\ICleanerProvider
		{

			public function getCleaner(): ?string
			{
				return 'uklizeč';
			}

		};

		$bot = new \Pd\CafeBot\Bot($messageProvider, $cleanerProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit uklizeč', $message);
	}


	public function testSpeechWithNameMention(): void
	{
		$messageProvider = new class implements \Pd\CafeBot\IMessageProvider
		{

			public function getMessage(): string
			{
				return 'Vyčistit %s';
			}
		};

		$cleanerProvider = new class implements \Pd\CafeBot\ICleanerProvider
		{

			public function getCleaner(): ?string
			{
				return '@uklizeč';
			}

		};

		$bot = new \Pd\CafeBot\Bot($messageProvider, $cleanerProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit <@uklizeč>', $message);
	}

}

(new SpeechTest())->run();
