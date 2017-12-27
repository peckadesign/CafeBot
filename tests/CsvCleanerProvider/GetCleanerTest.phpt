<?php declare(strict_types = 1);

namespace PdTests\CafeBot\CsvCleanerProvider;

include __DIR__ . '/../../vendor/autoload.php';

final class GetCleanerTest extends \Tester\TestCase
{

	public function testOutOfRange(): void
	{
		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider {

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2017-10-19');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider);
		\Tester\Assert::null($provider->getCleaner());
	}


	public function testInRange(): void
	{
		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider {

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2017-09-19');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider);
		\Tester\Assert::equal('Čistič B', $provider->getCleaner());
	}

}

(new GetCleanerTest())->run();
