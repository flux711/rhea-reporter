<?php

namespace rhea\report\modules;

class Module
{
	const MODULE_NAME = 'reporter';
	const API_VERSION = '0.0.1';

	public static function getName()
	{
		return self::MODULE_NAME;
	}

	public static function getLatestVersion()
	{
		return self::API_VERSION;
	}

}
