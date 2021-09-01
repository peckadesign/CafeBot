<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class Cleaner
{

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var null|string
	 */
	private $slackId;

	/**
	 * @var \Nette\Utils\DateTime
	 */
	private $from;

	/**
	 * @var \Nette\Utils\DateTime
	 */
	private $to;


	public function __construct(string $name, ?string $slackId, ?string $from, ?string $to)
	{
		$name = \trim($name);

		if ($name === '') {
			throw new \RuntimeException('Uživatel nemá zadané jméno');
		}
		
		$this->name = $name;
		$this->slackId = $slackId;

		if ( ! $from || ! $to) {
			throw new \RuntimeException('Uživatel nemá platné rozsahy úklidu');
		}

		$from = \Nette\Utils\DateTime::createFromFormat("j.n.Y", $from);
		$to = \Nette\Utils\DateTime::createFromFormat("j.n.Y", $to);

		if ( ! $from || ! $to) {
			throw new \RuntimeException('Uživatel nemá platné rozsahy úklidu');
		}

		$from->setTime(0, 0, 0);

		$this->from = $from;
		$this->to = $to;
	}


	public function isAvailableInDay(\DateTimeImmutable $now): bool
	{
		return $this->from->format('U') <= $now->format('U') && $this->to->format('U') >= $now->format('U');
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getSlackId(): ?string
	{
		return $this->slackId;
	}

}
