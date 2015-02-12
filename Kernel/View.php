<?php

namespace Kernel;

use Kernel\TemplateEngine\TemplateEngine;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class View extends TemplateEngine
{
	/**
	 * @param string $template_encode
	 * @param array $parameters
	 *
	 * @return Template $output
	 */
	public static function render($template_encode, array $parameters = array())
	{
		//encode the decoded template-path 
		$template_decode = explode(':',$template_encode);

		$ldefault_path = '..'. DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
		$rdefault_path = DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'views';

		foreach($template_decode as $key => $value){
			if(!empty($template_path)){
				$template_path .= DIRECTORY_SEPARATOR . $value;
			}
			else{
				$template_path = $ldefault_path.$value.$rdefault_path;
			}	
		}

		//check if the file exist if true then return the template 
		$file = $template_path;
		$exist = file_exists($file);
		if($exist){

			ob_start();

			include $file;
			$output = ob_get_contents();
			ob_end_clean();
			
			//transformate the template variables in PHP variables
			$TemplateEngine = new TemplateEngine;
			$TemplateEngine->init($output, $parameters);

			return $TemplateEngine->getOutput();
		}
		else{
			echo "nix";
			return 'could not found Template';
		}
	}
}