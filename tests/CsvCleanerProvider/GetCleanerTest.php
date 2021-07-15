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

		$holidayFacade = new class implements \Pd\Holidays\IHolidayFacade {

			public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?\Pd\Holidays\IHoliday
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}


			public function getHolidays(string $countryCode, int $year): \Pd\Holidays\IYear
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider, $holidayFacade);
		\Tester\Assert::null($provider->getCleaner());
	}


	public function testInRangeUserName(): void
	{
		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider {

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2017-09-19');
			}

		};

		$holidayFacade = new class implements \Pd\Holidays\IHolidayFacade {

			public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?\Pd\Holidays\IHoliday
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}


			public function getHolidays(string $countryCode, int $year): \Pd\Holidays\IYear
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider, $holidayFacade);
		\Tester\Assert::equal('Čistič B', $provider->getCleaner());
	}


	public function testInRangeSlackId(): void
	{
		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider {

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2017-09-26');
			}

		};

		$holidayFacade = new class implements \Pd\Holidays\IHolidayFacade {

			public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?\Pd\Holidays\IHoliday
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}


			public function getHolidays(string $countryCode, int $year): \Pd\Holidays\IYear
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider, $holidayFacade);
		\Tester\Assert::equal('@CCCC', $provider->getCleaner());
	}

}

(new GetCleanerTest())->run();
