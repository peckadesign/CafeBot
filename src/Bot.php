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


	public function __construct(
		IMessageProvider $messageProvider,
		ICleanerProvider $cleanerProvider
	)
	{
		$this->messageProvider = $messageProvider;
		$this->cleanerProvider = $cleanerProvider;
	}


	public function speech(): string
	{
		$message = $this->messageProvider->getMessage();

		$cleaner = NULL;

		if (strpos($message, '%s') !== FALSE) {
			$cleaner = $this->cleanerProvider->getCleaner();
			if ($cleaner !== NULL) {
				$cleaner = $this->createLinkFromCleaner($cleaner);
			} else {
				$cleaner = 'dnešní čistič';
			}

			$message = str_replace("%s", $cleaner, $message);
		}

		$nextCleaner = $this->cleanerProvider->getNextCleaner();

		if ($nextCleaner === NULL) {
			$nextCleaner = 'nějaká dobrá duše, domluvte se prosím';
		} else {
			$nextCleaner = $this->createLinkFromCleaner($nextCleaner);
		}

		if ($cleaner !== $nextCleaner) {
			$message .= \sprintf(' A příště uklízí %s.', $nextCleaner);
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
