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


	public function __construct(
		string $filePath,
		IDateTimeProvider $dateTimeProvider
	) {
		$this->filePath = $filePath;
		$this->dateTimeProvider = $dateTimeProvider;
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
		$today = $today->modify('next monday');

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
		$plans = preg_split('~[\r\n]+~', $data);
		array_shift($plans);

		$cleaner = NULL;

		foreach ($plans as $plan) {
			list($cleanerCandidate, $slackId, $from, $to) = explode(",", $plan);

			try {
				$cleaner = new Cleaner($cleanerCandidate, $slackId, $from, $to);
			} catch (\RuntimeException $e) {
				continue;
			}

			yield $cleaner;
		}
	}

}
