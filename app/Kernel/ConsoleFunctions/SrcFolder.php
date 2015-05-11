<?php

namespace Kernel\ConsoleFunctions;

use Kernel\Config;
use Tools\Folder\Folder;

class SrcFolder
{
	/**
	 *
	 * The generateFunction generates an Controller in srcFolder
	 *
	 * @return void
	 */
	public static function generate()
	{
		//get the Name of the SourceFolder
			echo "First you need to give the name of the SourceFolder you want to generate.\n";
			echo "The SourceFolder name: ";
			$line = trim(fgets(STDIN));
			$dir = 'src/'.$line;
		//controll when the Folder already exist
			while(is_dir($dir)){
				echo "This SourceFolder already exist! Do you want to overwrite this File?\npress y for yes and another for no:";
				$answer = trim(fgets(STDIN));
				if($answer === 'y'){
					Folder::delete($dir);
					break;
				}else{
					echo "The SourceFolder name: ";
					$line = trim(fgets(STDIN));
					$dir = 'src/'.$line;
				}
			}	
		//create dirs
			mkdir($dir);
			mkdir($dir.'/Controller');
			mkdir($dir.'/Entity');
			mkdir($dir.'/Resources');
			mkdir($dir.'/Resources/views');
		//set controllerValue
			$controllerValue = "<?php \n\n";
			$controllerValue .='namespace '.$line."\\Controller;\n\n";
			$controllerValue .='use Kernel\Controller;'."\n\n";						
			$controllerValue .='class '.$line."Controller extends Controller\n{\n";
			$controllerValue .='	public function '.$line.'()'."\n";
			$controllerValue .="	{\n";
			$controllerValue .='		return $this->render("'.$line.':default.html");'."\n";
			$controllerValue .="	}\n";
			$controllerValue .="}\n";
		//generate Controller
			$controller = fopen($dir.'/Controller/'.$line.'Controller.php', "w") or die("Unable to open file!\n");
			fwrite($controller, '');
			fwrite($controller, trim($controllerValue));
			fclose($controller);
		//generate template
			$templateValue = "<div>hello</div>";
			$template = fopen($dir.'/Resources/views/default.html', "w") or die("Unable to open file!\n");
			fwrite($template, '');
			fwrite($template, trim($templateValue));
			fclose($template);
		//amend srcInit
			if(!array_key_exists($line, Config::srcInit())){
				$content = $line.': '.$line;
				file_put_contents('Config/SrcInit.yml', "\n".$content, FILE_APPEND);
			}
	}
}