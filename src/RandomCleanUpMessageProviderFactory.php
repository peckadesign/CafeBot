<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class RandomCleanUpMessageProviderFactory implements IMessageProviderFactory
{

	/**
	 * @var array|string[]
	 */
	private $messages;

	/**
	 * @var array|string[]
	 */
	private $fridayMessages;


	public function __construct(array $messages, array $fridayMessages)
	{
		$this->messages = $messages;
		$this->fridayMessages = $fridayMessages;
	}


	public function create(\DateTimeImmutable $dateTime): IMessageProvider
	{
		$dayOfWeek = (int) $dateTime->format('N');

		if ($dayOfWeek === 5) {
			return new RandomCleanUpMessage($this->fridayMessages);
		} else {
			return new RandomCleanUpMessage($this->messages);
		}
	}

}
