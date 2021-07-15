<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class CsvCleanerProvider implements ICleanerProvider
{

	/**
	 * @var string
	 */
	private $filePath;

	/**
	 * @var IDateTimeProvider
	 */
	private $dateTimeProvider;

	private \Pd\Holidays\IHolidayFacade $holidayFacade;


	public function __construct(
		string $filePath,
		IDateTimeProvider $dateTimeProvider,
		\Pd\Holidays\IHolidayFacade $holidayFacade
	)
	{
		$this->filePath = $filePath;
		$this->dateTimeProvider = $dateTimeProvider;
		$this->holidayFacade = $holidayFacade;
	}


	public function getCleaner(): ?string
	{
		$today = $this->dateTimeProvider->getDateTime();

		foreach ($this->parseCleaners() as $cleaner) {
			if ($cleaner->isAvailableInDay($today)) {
				return $cleaner->getSlackId() ? '@' . $cleaner->getSlackId() : $cleaner->getName();
			}
		}

		return NULL;
	}


	public function getNextCleaner(): ?string
	{
		$today = $this->dateTimeProvider->getDateTime();

		do {
			$today = $today->modify('next day');
			if (\in_array($today->format('N'), ['6', '7'], TRUE)) {
				continue;
			}
			$holiday = $this->holidayFacade->getHoliday(\Pd\Holidays\Localizations\ICzech::COUNTRY_CODE_CZECH, $today);
			if ($holiday !== NULL) {
				continue;
			}
			break;
		} while (TRUE);

		foreach ($this->parseCleaners() as $cleaner) {
			if ($cleaner->isAvailableInDay($today)) {
				return $cleaner->getSlackId() ? '@' . $cleaner->getSlackId() : $cleaner->getName();
			}
		}

		return NULL;
	}


	/**
	 * @return iterable|Cleaner[]
	 */
	private function parseCleaners(): iterable
	{
		$data = file_get_contents($this->filePath);

		if ($data === FALSE) {
			return [];
		}

		$plans = preg_split('~[\r\n]+~', $data);

		if ($plans === FALSE) {
			return [];
		}

		array_shift($plans);

		$cleaner = NULL;

		foreach ($plans as $plan) {
			[$cleanerCandidate, $slackId, $from, $to] = explode(",", $plan);

			try {
				$cleaner = new Cleaner($cleanerCandidate, $slackId, $from, $to);
			} catch (\RuntimeException $e) {
				continue;
			}

			yield $cleaner;
		}
	}

}
