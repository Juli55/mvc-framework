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
	private $output;

	/**
	 *
	 * The init Function calls the TemplateParser and sets the objectProberty $output
	 *
	 * @param string $output
	 * @param array $parameters
	 *
	 * @return void
	 */
	public function init($output, $parameters)
	{
		$TemplateParser = new TemplateParser($output,$parameters);
		$this->output = $TemplateParser->getOutput();
	}

	/**
	 * @return string
	 */
	public function getOutput()
	{
		return $this->output;
	}
}