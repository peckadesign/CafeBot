<?php declare(strict_types = 1);

namespace PdTests\CafeBot\Notifier;

include __DIR__ . '/../../vendor/autoload.php';

/**
 * @skip
 */
final class EnabledTest extends \Tester\TestCase
{

	public function getTestWeekendDate(): array
	{
		return [
			['2017-12-09'],
			['2017-12-10'],
		];
	}

	/**
	 * @dataProvider getTestWeekendDate
	 */
	public function testWeekend(string $dateTime): void
	{
		$dateTimeProvider = new class($dateTime) implements \Pd\CafeBot\IDateTimeProvider
		{

			/**
			 * @var string
			 */
			private $dateTime;


			public function __construct(string $dateTime)
			{
				$this->dateTime = $dateTime;
			}


			public function getDateTime(): \DateTimeImmutable
			{
				return new \DateTimeImmutable($this->dateTime);
			}
		};

		$holidayFacade = new class implements \Pd\Holidays\IHolidayFacade
		{

			public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?\Pd\Holidays\IHoliday
			{
				\Tester\Assert::fail('Metoda není implementována');
			}


			public function getHolidays(string $countryCode, int $year): \Pd\Holidays\IYear
			{
				\Tester\Assert::fail('Metoda není implementována');
			}
		};

		$notifier = new \Pd\CafeBot\Notifier($dateTimeProvider, $holidayFacade);
		\Tester\Assert::false($notifier->enabled());
	}
}

(new EnabledTest())->run();
