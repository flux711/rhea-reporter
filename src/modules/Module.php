<?php

namespace report\src\modules;

class Module
{
	const MODULE_NAME = 'reporter';
	const API_VERSION = '1.0.0';

	public static function getName()
	{
		return self::MODULE_NAME;
	}

	public static function getLatestVersion()
	{
		return self::API_VERSION;
	}

}
