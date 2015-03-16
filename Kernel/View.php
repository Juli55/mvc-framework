<?php

namespace Kernel;

use Kernel\TemplateEngine\TemplateEngine;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class View extends TemplateEngine
{
	/**
	 *
	 * The renderMethod renders the template to display it
	 *
	 * @param string $templateEncode
	 * @param array $parameters
	 *
	 * @return string
	 */
	public static function render($templateEncode = '', $parameters = array(), $content = '')
	{
		if(empty($content)){
			//encode the decoded template-path 
				$templateDecode = explode(':',$templateEncode);
			//define templatePath
				$ldefaultPath = '..'. DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
				$rdefaultPath = DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'views';
				foreach($templateDecode as $key => $value){
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
					
					//parse Template
						$TemplateEngine = new TemplateEngine;
						$TemplateEngine->init($output, $parameters);

					return $TemplateEngine->getOutput();
				}else{
					//throw Exception
						die('template doesn\'t exist'. $templatePath);
				}
		}else{
			//parse Template
				$TemplateEngine = new TemplateEngine;
				$TemplateEngine->init($content, $parameters);
			return $TemplateEngine->getOutput();
		}
	}
}