<?php declare(strict_types = 1);

include __DIR__ . '/../vendor/autoload.php';

$containerLoader = new \Nette\DI\ContainerLoader(__DIR__ . '/../temp');
$containerClass = $containerLoader->load(function (\Nette\DI\Compiler $container) {
	$container->loadConfig(__DIR__ . '/../config/config.neon');
	$container->addExtension('holidays', new \Pd\Holidays\DI\Extension());
});

/** @var \Nette\DI\Container $container */
$container = new $containerClass();

/** @var \Pd\CafeBot\Command $command */
$command = $container->getByType(\Pd\CafeBot\Command::class);

$command->execute();
