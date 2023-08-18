<?php

namespace rhea\report\models;

class Module
{
	const MODULE_NAME = 'reporter';
	const API_VERSION = '0.0.1';

	public static function getLatestVersion()
	{
		return self::API_VERSION;
	}

	public static function getName()
	{
		return self::MODULE_NAME;
	}

}
