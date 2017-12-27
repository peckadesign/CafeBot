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
	) {
		$this->messageProvider = $messageProvider;
		$this->cleanerProvider = $cleanerProvider;
	}


	public function speech(): string
	{
		$message = $this->messageProvider->getMessage();

		if (strpos($message, '%s') !== FALSE) {
			$cleaner = $this->cleanerProvider->getCleaner();

			if (substr($cleaner, 0, 1) === '@') {
				$cleaner = '<' . $cleaner . '>';
			}

			$message = str_replace("%s", $cleaner, $message);
		}

		return $message;
	}

}
