<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class RandomCleanUpMessage implements IMessageProvider
{

	/**
	 * @var array|string[]
	 */
	private $messages = [
		'Dneska čistí třebááá %s. Nezapomeň na mě!',
		'Dnes jsem hodně špinavý, už se těším až mě %s vyčistí... Kdy přijdeš?',
		'Jsem tu tak sám, přijde někdo za mnou a vyčístí mě? Co třeba %s?',
		'Haló, děcka, čistit! Někoho pošlete, co třeba %s? Máš čas?',
		'Tak co je? Kde je %s, je vůbec v práci? Jestli nepřijdeš a nevyčistíš mě, tak to na tebe řeknu! ',
		'Dneska by mě mohl %s pořádně vydrhnout, ať jsem zítra fešák.',
		'Já mám takový pocit, že na mě dneska %s zapomněl a já jsem tu sám, špinavý, fňuk...',
		'Minule to bylo nádherné, už se teším až zase přijde %s a pořádně mi protáhne závit. A nešetři mě, ty ďáble!',
	];

	private $messagesFriday = [
		'Tak máme tady pátek, už se těším až přijde %s. Nezapomeň, že dneska je velké čištění, pořádně vydrhnout a použij chemii. Myslím, že je ve skříňce pod dřezem, tak dej trochu (na špičku nože) do každé nádoby na páku.',
		'Hurá, pátek! Přijde za mnou %s? Nezapomeň, že dneska je velká čistka, natáhni gumové rukavice, vem si nějaké tričko, které si můžeš umazat, gumáky a pojď na to.',
		'Jejdamane, to už je pátek? Tak to je hustý, to uteklo. %s už jdeš? Dneska si dej záležet, ať tu neležím přes víkend ve špíně. Dneska se dává chemie.',
	];


	public function getMessage(): string
	{
		if (date('N') === 5) {
			$messages = $this->messages;
		} else {
			$messages = $this->messagesFriday;
		}

		try {
			$messageIndex = random_int(0, count($messages) - 1);
		} catch (\Exception $e) {
			$messageIndex = substr((string) crc32((string) time()), 0, 1) || 0;
		}

		return $messages[$messageIndex];
	}

}
