<?php

namespace Kernel;

use Kernel\TemplateEngine\TemplateEngine;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class View extends TemplateEngine
{
	/**
	 * @var array
	 */
	public static $parameters;

	/**
	 * @var blocks
	 */
	public static $blocks;

	/**
	 * @var string
	 */
	public static $srcFolder;

	/**
	 *
	 * The renderMethod renders the template to display it
	 *
	 * @param string $templateEncode
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function render($templateEncode, $parameters = array(), $blocks = array(), $content = '')
	{
		if(!empty($templateEncode)){
			//encode the decoded template-path 
				$templateDecode  = explode(':',$templateEncode);
				self::$srcFolder = $templateDecode[0];
			//define templatePath
				$ldefaultPath = '..'. DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
				$rdefaultPath = DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'views';
				foreach($templateDecode as $key => $value){
					$value = trim($value, '\'');
					if(!empty($templatePath)){
						$templatePath .= DIRECTORY_SEPARATOR . $value;
					}
					else{
						$templatePath = $ldefaultPath.$value.$rdefaultPath;
					}	
				}
			//check if the file exist if true then return the template 
				$file = $templatePath;
				$exist = file_exists($file);
				if($exist){

					ob_start();

					include $file;
					$output = ob_get_contents();
					ob_end_clean();
					
					//transformate the template variables in PHP variables
						$TemplateEngine = new TemplateEngine;
						$TemplateEngine->init($output, $parameters, $blocks);
						return $TemplateEngine->getOutput();
				}else{
					//throw Exception
						die('template doesn\'t exist');
				}
			}else{
				//transformate the template variables in PHP variables
					$TemplateEngine = new TemplateEngine;
					$TemplateEngine->init($content, $parameters, $blocks);
					return $TemplateEngine->getOutput();
			}
	}
}