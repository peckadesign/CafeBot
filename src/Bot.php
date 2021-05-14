<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class Bot
{

	/**
	 * @var IMessageProvider
	 */
	private $messageProvider;


	public function __construct(
		IMessageProvider $messageProvider
	) {
		$this->messageProvider = $messageProvider;
	}


	public function speech(): string
	{
		return $this->messageProvider->getMessage();
	}

}
