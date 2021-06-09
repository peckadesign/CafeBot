<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class Bot
{

	/**
	 * @var IMessageProvider
	 */
	private $messageProvider;

	/**
	 * @var ICleanerProvider
	 */
	private $cleanerProvider;

	/**
	 * @var IDateTimeProvider
	 */
	private $dateTimeProvider;


	public function __construct(
		IMessageProvider $messageProvider,
		ICleanerProvider $cleanerProvider,
		IDateTimeProvider $dateTimeProvider
	) {
		$this->messageProvider = $messageProvider;
		$this->cleanerProvider = $cleanerProvider;
		$this->dateTimeProvider = $dateTimeProvider;
	}


	public function speech(): string
	{
		$message = $this->messageProvider->getMessage();

		if (strpos($message, '%s') !== FALSE && ($cleaner = $this->cleanerProvider->getCleaner())) {
			$cleaner = $this->createLinkFromCleaner($cleaner);

			$message = str_replace("%s", $cleaner, $message);
		}

		if (((int) $this->dateTimeProvider->getDateTime()->format('N')) === 5 && ($nextCleaner = $this->cleanerProvider->getNextCleaner())) {
			$message .= \sprintf(' A příště uklízí %s', $this->createLinkFromCleaner($nextCleaner));
		}

		return $message;
	}


	private function createLinkFromCleaner(string $cleaner): string
	{
		if (substr($cleaner, 0, 1) === '@') {
			$cleaner = '<' . $cleaner . '>';
		}

		return $cleaner;
	}

}
