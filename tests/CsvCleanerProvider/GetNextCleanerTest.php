<?php declare(strict_types = 1);

namespace PdTests\CafeBot\CsvCleanerProvider;

include __DIR__ . '/../../vendor/autoload.php';

final class GetNextCleanerTest extends \Tester\TestCase
{

	public function testOutOfRange(): void
	{
		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider
		{

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2017-09-28'); // čtvrtek
			}

		};

		$holidayFacade = new class implements \Pd\Holidays\IHolidayFacade {

			public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?\Pd\Holidays\IHoliday
			{
				return NULL;
			}


			public function getHolidays(string $countryCode, int $year): \Pd\Holidays\IYear
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider, $holidayFacade);
		\Tester\Assert::null($provider->getNextCleaner());
	}


	public function testInRangeSlackId(): void
	{
		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider
		{

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2017-09-19');
			}

		};

		$holidayFacade = new class implements \Pd\Holidays\IHolidayFacade {

			public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?\Pd\Holidays\IHoliday
			{
				return NULL;
			}


			public function getHolidays(string $countryCode, int $year): \Pd\Holidays\IYear
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider, $holidayFacade);
		\Tester\Assert::equal('Čistič B', $provider->getNextCleaner());
	}


	public function testWeekend(): void
	{
		$dateTimeProvider = new class implements \Pd\CafeBot\IDateTimeProvider
		{

			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable('2021-07-15'); // čtvrtek
			}

		};

		$holidayFacade = new class implements \Pd\Holidays\IHolidayFacade {

			public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?\Pd\Holidays\IHoliday
			{
				\Tester\Assert::equal(\Pd\Holidays\Localizations\ICzech::COUNTRY_CODE_CZECH, $countryCode);
				if ('2021-07-16' === $dateTime->format('Y-m-d')) {
					return new \Pd\Holidays\Holiday(7, 16, 'Svátek v pátek');
				}

				\Tester\Assert::equal('2021-07-19', $dateTime->format('Y-m-d'));

				return NULL;
			}


			public function getHolidays(string $countryCode, int $year): \Pd\Holidays\IYear
			{
				\Tester\Assert::fail('Metoda nesmí být zavolána');
			}

		};

		$provider = new \Pd\CafeBot\CsvCleanerProvider(__DIR__ . '/data.csv', $dateTimeProvider, $holidayFacade);
		\Tester\Assert::equal('@DDDD', $provider->getNextCleaner());
	}

}

(new GetNextCleanerTest())->run();
