<?php declare(strict_types = 1);

namespace Pd\CafeBot;

interface ICleanerProvider
{

	public function getCleaner(): ?string;

	public function getNextCleaner(): ?string;

}
