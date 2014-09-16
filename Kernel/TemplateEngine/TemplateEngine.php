<?php

namespace Kernel\TemplateEngine;

use Kernel\TemplateEngine\TemplateParser;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class TemplateEngine
{
	/**
	 * @var string
	 */
	private static $output;

	public function init($output, $parameters)
	{
		$TemplateParser = new TemplateParser($output,$parameters);
		self::$output = $TemplateParser->getOutput();
	}

	public function getOutput()
	{
		return self::$output;
	}
}