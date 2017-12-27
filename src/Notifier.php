<?php declare(strict_types = 1);

namespace Pd\CafeBot;

final class Notifier implements INotifier
{

	/**
	 * @var \Pd\Holidays\IHolidayFacade
	 */
	private $holidayFacade;

	/**
	 * @var IDateTimeProvider
	 */
	private $dateTimeProvider;


	public function __construct(
		IDateTimeProvider $dateTimeProvider,
		\Pd\Holidays\IHolidayFacade $holidayFacade
	)
	{

		$this->dateTimeProvider = $dateTimeProvider;
		$this->holidayFacade = $holidayFacade;
	}


	public function enabled(): bool
	{
		$now = $this->dateTimeProvider->getDateTime();

		if ((int) $now->format('N') > 5) {
			return FALSE;
		}

		return ! (bool) $this->holidayFacade->getHoliday(\Pd\Holidays\Localizations\ICzech::COUNTRY_CODE_CZECH, $now);
	}

}
