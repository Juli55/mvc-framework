<?php
namespace Kernel\ConsoleFunctions;

class Entity
{
	public static function generate()
	{
		// ask for the Entity shortcut name
			echo "First you need to give the entity name you want to generate.\nYou must use the shortcut notation like SourceFolder:User\n";
			echo "The Entity shortcut name: ";
			$shortcut = trim(fgets(STDIN));

		// split the short name in the srcfolder and entityname
			$explodedShort =  explode(':',$shortcut);

		// loop asking for shortcut name if entityname isn't set
			while(!isset($explodedShort[1])) {
				echo "The Entity shortcut name: ";
				$shortcut = trim(fgets(STDIN));
				$explodedShort =  explode(':',$shortcut);
			}
		// set splittet shortcutname in variables
			$srcDir = $explodedShort[0];
			$entityName = $explodedShort[1];

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
				$explodedShort =  explode(':',$shortcut);
				while(!isset($explodedShort[1])){
					echo "The Entity shortcut name: ";
					$shortcut = trim(fgets(STDIN));
					$explodedShort =  explode(':',$shortcut);
				}
				$srcDir = $explodedShort[0];
				$entityName = $explodedShort[1];
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
}