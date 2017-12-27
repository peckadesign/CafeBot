<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class NowDateTimeProvider implements IDateTimeProvider
{

	public function getDateTime(): \DateTimeImmutable
	{
		return new \DateTimeImmutable();
	}

}
