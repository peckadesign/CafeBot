<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class RandomCleanUpMessage implements IMessageProvider
{

	/**
	 * @var array|string[]
	 */
	private $messages = [
		'Dnes jsem hodně špinavý, už se těším až mě %s vyčistí... Kdy přijdeš?',
		'Jsem tu tak sám, přijde někdo za mnou a vyčístí mě? Co třeba %s?',
		'Haló, děcka, čistit! Někoho pošlete, co třeba %s? Máš čas?',
		'Dneska by mě mohl %s pořádně vydrhnout, ať jsem zítra fešák.',
		'Já mám takový pocit, že na mě dneska %s zapomněl a já jsem tu sám, špinavý, fňuk...',
		'Minule to bylo nádherné, už se teším až zase přijde %s a pořádně mi protáhne závit. A nešetři mě, ty ďáble!',
	];


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
