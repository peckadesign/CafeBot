<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class RandomCleanUpMessage implements IMessageProvider
{

	/**
	 * @var array|string[]
	 */
	private $messages;


	/**
	 * @param array|string[] $messages
	 */
	public function __construct(
		array $messages
	) {
		$this->messages = $messages;
	}


	public function getMessage(): string
	{
		try {
			$messageIndex = random_int(0, count($this->messages) - 1);
		} catch (\Exception $e) {
			$messageIndex = substr((string) crc32((string) time()), 0, 1) || 0;
		}

		return $this->messages[$messageIndex];
	}

}
