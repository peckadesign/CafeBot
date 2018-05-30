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
		$data = file_get_contents($this->filePath);
		$plans = preg_split('~[\r\n]+~', $data);
		array_shift($plans);

		$today = $this->dateTimeProvider->getDateTime();

		$cleaner = NULL;

		foreach ($plans as $plan) {
			list($cleanerCandidate, $slackId, $from, $to) = explode(",", $plan);

			$from = \Nette\Utils\DateTime::createFromFormat("j.n.Y", $from);
			$to = \Nette\Utils\DateTime::createFromFormat("j.n.Y", $to);

			if ( ! $from) {
				continue;
			}
			if ( ! $to) {
				continue;
			}

			if ($from && $to && $from->format('U') <= $today->format('U') && $to->format('U') >= $today->format('U')) {
				$cleaner = $slackId ? '@' . $slackId : $cleanerCandidate;
			}
		}

		return $cleaner;
	}

}
