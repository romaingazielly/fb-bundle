<?php

namespace Wise\FacebookBundle;

class AppPlatformResolver
{
	const PLATFORM_DESKTOP = 'desktop';

	const PLATFORM_MOBILE  = 'mobile';

	public function getResolvedPlatformUrl()
	{
		$detect = new \Mobile_Detect();

		if ($detect->isMobile()) {

		}
	}
}
