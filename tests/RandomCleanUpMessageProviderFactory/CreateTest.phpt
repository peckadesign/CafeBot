<?php declare(strict_types = 1);

namespace PdTests\CafeBot\RandomCleanUpMessageProviderFactory;

include __DIR__ . '/../../vendor/autoload.php';

final class CreateTest extends \Tester\TestCase
{

	public function testCreate(): void
	{
		$messages = [
			'qwertz',
		];
		$fridayMessages = [
			'asdfgh',
		];
		$factory = new \Pd\CafeBot\RandomCleanUpMessageProviderFactory($messages, $fridayMessages);

		$provider = $factory->create(new \DateTimeImmutable('next monday'));
		\Tester\Assert::equal('qwertz', $provider->getMessage());

		$provider = $factory->create(new \DateTimeImmutable('next friday'));
		\Tester\Assert::equal('asdfgh', $provider->getMessage());
	}

}

(new CreateTest())->run();
