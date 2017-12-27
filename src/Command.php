<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class Command
{

	/**
	 * @var INotifier
	 */
	private $notifier;

	/**
	 * @var Bot
	 */
	private $bot;

	/**
	 * @var Slack
	 */
	private $slack;


	public function __construct(
		INotifier $notifier,
		Bot $bot,
		Slack $slack
	) {
		$this->notifier = $notifier;
		$this->bot = $bot;
		$this->slack = $slack;
	}


	public function execute(): void
	{
		if ( ! $this->notifier->enabled()) {
			return;
		}

		$message = $this->bot->speech();
		$this->slack->send($message, "#café", 'Kávovar', ':coffee:');
	}

}
