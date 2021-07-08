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
				return NULL;
			}
		};

		$bot = new \Pd\CafeBot\Bot($messageProvider, $cleanerProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit A příště uklízí nějaká dobrá duše, domluvte se prosím.', $message);
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


			public function getNextCleaner(): ?string
			{
				return NULL;
			}
		};

		$bot = new \Pd\CafeBot\Bot($messageProvider, $cleanerProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit uklizeč A příště uklízí nějaká dobrá duše, domluvte se prosím.', $message);
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


			public function getNextCleaner(): ?string
			{
				return NULL;
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

		\Tester\Assert::equal('Vyčistit <@uklizeč> A příště uklízí nějaká dobrá duše, domluvte se prosím.', $message);
	}


	public function testSpeechChangeCleaner(): void
	{
		$messageProvider = new class implements \Pd\CafeBot\IMessageProvider
		{

			public function getMessage(): string
			{
				return 'Vyčistit %s.';
			}
		};

		$cleanerProvider = new class implements \Pd\CafeBot\ICleanerProvider
		{

			public function getCleaner(): ?string
			{
				return '@uklizeč';
			}


			public function getNextCleaner(): ?string
			{
				return '@uklizeč2';
			}
		};

		$bot = new \Pd\CafeBot\Bot($messageProvider, $cleanerProvider);
		$message = $bot->speech();

		\Tester\Assert::equal('Vyčistit <@uklizeč>. A příště uklízí <@uklizeč2>.', $message);
	}

}

(new SpeechTest())->run();
