<?php declare(strict_types = 1);

namespace Pd\CafeBot;

interface IMessageProviderFactory
{

	public function create(\DateTimeImmutable $dateTime): IMessageProvider;

}
