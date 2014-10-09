<?php
namespace Kernel\ConsoleFunctions;
use Kernel\DataBase\DB;
use Config\DBConfig;

/**
 * @author Julian Bertsch <Julian.bertch42@gmail.com>
 */
class ConsoleFunctions
{
	private function __autoload($class_name)
	{
	    include $class_name . '.php';
	}

	private static function deleteDir($dirPath)
	{
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}

	public static function generateEntity()
	{
		// ask for the Entity shortcut name
			echo "First you need to give the entity name you want to generate.\nYou must use the shortcut notation like SourceFolder:User\n";
			echo "The Entity shortcut name: ";
			$shortcut = trim(fgets(STDIN));

		// split the short name in the srcfolder and entityname
			$explodedShort =  explode(':',$shortcut);

		// loop asking for shortcut name if entityname isn't set
			while(!isset($explodedLine[1])){
				echo "The Entity shortcut name: ";
				$shortcut = trim(fgets(STDIN));
				$explodedLine =  explode(':',$shortcut);
			}
		// set splittet shortcutname in variables
			$srcDir = $explodedLine[0];
			$entityName = $explodedLine[1];

		// loop if dir doesn't exist or the entity file for this already exist
			while(!is_dir("src/$srcDir") || file_exists("src/$srcDir/Entity/$entityName.php")){

				if(!is_dir("src/$srcDir")){

					echo "This SourceFolder doesn't exist!\n";
				}
				if(file_exists("src/$srcDir/Entity/$entityName.php")){

					echo "This EntityFile already exist! Do you want to overwrite this File?\npress y for yes and another for no:";
					$answer = trim(fgets(STDIN));
					if($answer === 'y'){
						break;
					}
				}
				echo "The Entity shortcut name: ";
				$shortcut = trim(fgets(STDIN));
				$explodedLine =  explode(':',$shortcut);
				while(!isset($explodedLine[1])){
					echo "The Entity shortcut name: ";
					$shortcut = trim(fgets(STDIN));
					$explodedLine =  explode(':',$shortcut);
				}
				$srcDir = $explodedLine[0];
				$entityName = $explodedLine[1];
			}
		// set the entity fields		
			$shortcut = 1;
			$columns = array();
			$columns[] = 'id';
			while(!empty($shortcut)){
				echo "\nNew field name <press <return> to stop adding fields>: ";
				$shortcut = trim(fgets(STDIN));
				if(!empty($shortcut)){
					$columns[] = $shortcut;
				}
			}
		//set the file value
			$fileValue = "<?php \n\nnamespace $srcDir\\Entity;\n\nclass $entityName\n{\n";
			foreach ($columns as $value) {
			$fileValue .= "	/**\n";
			$fileValue .= "	 * @var string\n";
				$fileValue .= "	 */\n";
				$fileValue .= "	private \$$value;\n\n";
			}				
			foreach ($columns as $value) {

				$fileValue .= "	/**\n";
				$fileValue .= "	 * Set $value\n";
				$fileValue .= "	 *\n";
				$fileValue .= "	 * @param string \$$value\n";
				$fileValue .= "	 * @return $entityName\n";
				$fileValue .= "	 */\n";

				$fileValue .= "	public function set".ucfirst($value)."(\$$value)\n	{\n		\$this->$value = \$$value;\n\n		return \$this;\n	}\n\n";

				$fileValue .= "	/**\n";
				$fileValue .= "	 * Get $value\n";
				$fileValue .= "	 *\n";
				$fileValue .= "	 * @return string\n";
				$fileValue .= "	 */\n";

				$fileValue .= "	public function get".ucfirst($value)."()\n	{\n		return \$this->$value;\n	}\n\n";
			}					
			if(!is_dir('src/'.$srcDir.'/Entity')){
				mkdir('src/'.$srcDir.'/Entity',0700);
			}

		// generate the entity file in sourcefolder
			$myfile = fopen("src/$srcDir/Entity/$entityName.php", "w") or die("Unable to open file!\n");
			fwrite($myfile, '');
			fwrite($myfile, trim($fileValue)."\n}");
			fclose($myfile);
	}

	public static function generateSrcFolder()
	{
		// Get the Name of the SourceFolder
			echo "First you need to give the name of the SourceFolder you want to generate.\n";
			echo "The SourceFolder name: ";
			$line = trim(fgets(STDIN));
			$dir = 'src/'.$line;
		
		// controll when the Folder already exist
			while(is_dir($dir)){
				echo "This SourceFolder already exist! Do you want to overwrite this File?\npress y for yes and another for no:";
				$answer = trim(fgets(STDIN));
				if($answer === 'y'){
					self::deleteDir($dir);
					break;
				}else{
					echo "The SourceFolder name: ";
					$line = trim(fgets(STDIN));
					$dir = 'src/'.$line;
				}
			}
				
		// create dirs
			mkdir($dir);
			mkdir($dir.'/Controller');
			mkdir($dir.'/Entity');
			mkdir($dir.'/Resources');
			mkdir($dir.'/Resources/views');

		// generate Controller
			$controllerValue = "<?php \n\n";
			$controllerValue .='namespace '.$line."\\Controller;\n\n";
			$controllerValue .='use Kernel\Controller;'."\n\n";						
			$controllerValue .='class '.$line."Controller extends Controller\n{\n";
			$controllerValue .='	public function '.$line.'()'."\n";
			$controllerValue .="	{\n";
			$controllerValue .='		return $this->render("'.$line.':default.html");'."\n";
			$controllerValue .="	}\n";
			$controllerValue .="}\n";

			$controller = fopen($dir.'/Controller/'.$line.'Controller.php', "w") or die("Unable to open file!\n");
			fwrite($controller, '');
			fwrite($controller, trim($controllerValue));
			fclose($controller);

		// generate template
			$templateValue = "<div>hello</div>";
			$template = fopen($dir.'/Resources/views/default.html', "w") or die("Unable to open file!\n");
			fwrite($template, '');
			fwrite($template, trim($templateValue));
			fclose($template);
	}

	public static function createDatabase()
	{
		// init DB
		$db = new DB();
		DBConfig::init();

		foreach(DBConfig::getDatabases() as $key => $value){

			$sql_check = "SHOW DATABASES LIKE '$value'";
			$result = $db::$db->query($sql_check);

			if(!mysqli_num_rows($result) > 0){
				$sql = "CREATE DATABASE $value";
				$db::$db->query($sql) or die($db::$db->error);
			}else{
					echo "The Database '$value' does already exist do you want to replace it\npress y for yes and another for no:";
					$answer = trim(fgets(STDIN));
					if($answer === 'y'){
						$sql = "DROP DATABASE $value";
						$db::$db->query($sql) or die($db::$db->error);

						$sql = "CREATE DATABASE $value";
						$db::$db->query($sql) or die($db::$db->error);
					}
				}
		}
	}//end function
}