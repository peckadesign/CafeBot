<?php declare(strict_types = 1);

namespace Pd\CafeBot;

interface IDateTimeProvider
{

	public function getDateTime(): \DateTimeImmutable;

}
