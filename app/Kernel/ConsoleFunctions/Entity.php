<?php

namespace Kernel\ConsoleFunctions;

class Entity
{
	/**
	 *
	 * The generateMethod generates an EntityFile
	 *
	 * @return void
	 */
	public static function generate()
	{
		$fieldTypes = array('int','varchar','text','date','tinyint');
		//ask for the Entity shortcut name
			echo "First you need to give the entity name you want to generate.\nYou must use the shortcut notation like SourceFolder:User\n";
			echo "The Entity shortcut name: ";
			$shortcut = trim(fgets(STDIN));
		//split the short name in the srcfolder and entityname
			$explodedShort =  explode(':',$shortcut);
		//loop asking for shortcut name if entityname isn't set
			while(!isset($explodedShort[1])){
				echo "The Entity shortcut name: ";
				$shortcut = trim(fgets(STDIN));
				$explodedShort =  explode(':',$shortcut);
			}
		//set splittet shortcutname in variables
			$srcDir = $explodedShort[0];
			$entityName = $explodedShort[1];
		//loop if dir doesn't exist or the entity file for this already exist
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
					$shortcut 		= trim(fgets(STDIN));
					$explodedShort 	=  explode(':',$shortcut);
				}
				$srcDir = $explodedShort[0];
				$entityName = $explodedShort[1];
			}
		//set the entity fields		
			$columns = self::setEntityFields($fieldTypes);
		//set the file value
			$fileValue = self::setFileValue($srcDir, $entityName, $columns);
		//create Folder if not exist					
			if(!is_dir('src/'.$srcDir.'/Entity')){
				mkdir('src/'.$srcDir.'/Entity',0700);
			}
		//generate the entity file in sourcefolder
			$myfile = fopen("src/$srcDir/Entity/$entityName.php", "w") or die("Unable to open file!\n");
			fwrite($myfile, '');
			fwrite($myfile, trim($fileValue)."\n}");
			fclose($myfile);
	}

	/**
	 *
	 * this function stores the EntityFields in an Array and return it
	 *
	 * @param array $fieldTypes
	 *
	 * @return array
	 */
	private function setEntityFields($fieldTypes)
	{
		//set the entity fields		
			$fieldName = 1;
			$columns   = array();
			//set id as first column
				$columns[] = array('fieldName' => 'id','fieldType' => 'int','fieldLength' => 255);
			while(!empty($fieldName)){
				$column = array();
				echo "\nNew field name <press <return> to stop adding fields>: ";
				$fieldName = trim(fgets(STDIN));
				if(!empty($fieldName)){
					//here ask for type length and required
						$exist = false;
						while(!$exist){
							echo "\nDefine the FieldType <press <return> to take the standart 'varchar'>: ";
							$type = trim(fgets(STDIN));
							//set Type
								if(!empty($type)){
									//check validity	
										foreach($fieldTypes as $fieldType){
											if($type == $fieldType){
												$exist = true;
											}
										}
										if($exist){
											$column['fieldType'] = $type;
										}else{
											echo "\nUnknown FieldType! Repeat";
										}
								}else{
									$exist = true;
									$column['fieldType'] = 'varchar';
								}
						}
					//set length
						$legal = false;
						while(!$legal){
							echo "\nDefine the FieldLength > 0 AND <= 255 <press <return> to take the standart '255'>: ";
							$length = trim(fgets(STDIN));
							if(!empty($length)){	
								if(intval($length) > 0 && intval($length) <= 255){
									$legal = true;
									$column['fieldLength'] = $length;
								}else{
									echo "\nIllegal FieldLength! Repeat";
								}
							}else{
								$legal = true;
								$column['fieldLength'] = 255;
							}
						}
					//add column
						$column['fieldName'] = $fieldName;
						$columns[] = $column;
				}
			}
		return $columns;
	}

	/**
	 *
	 * this function set the FileValue and returns it 
	 *
	 * @param string $srcDir, $entityName
	 * @param array $columns
	 *
	 * @return string
	 */
	private function setFileValue($srcDir, $entityName, $columns)
	{
		//set the file value
			$fileValue = "<?php \n\nnamespace $srcDir\\Entity;\n\nclass $entityName\n{\n";
			foreach($columns as $value){
				//set information
					$name   = $value['fieldName'];
					$type   = $value['fieldType'];
					$length = $value['fieldLength'];
				//add to fileValue
					$fileValue .= "	/**\n";
					$fileValue .= "	 * @var string\n";
					$fileValue .= "	 * @prob('name' = $name)\n";
					$fileValue .= "	 * @prob('type' = $type)\n";
					$fileValue .= "	 * @prob('length' = $length)\n";
					$fileValue .= "	 */\n";
					$fileValue .= "	private \$$name;\n\n";
			}				
			foreach($columns as $value){
				//set name
					$name   = $value['fieldName'];
				//add to fileValue
					$fileValue .= "	/**\n";
					$fileValue .= "	 * Set $name\n";
					$fileValue .= "	 *\n";
					$fileValue .= "	 * @param string \$$name\n";
					$fileValue .= "	 * @return $entityName\n";
					$fileValue .= "	 */\n";
					$fileValue .= "	public function set".ucfirst($name)."(\$$name)\n	{\n		\$this->$name = \$$name;\n\n		return \$this;\n	}\n\n";
					$fileValue .= "	/**\n";
					$fileValue .= "	 * Get $name\n";
					$fileValue .= "	 *\n";
					$fileValue .= "	 * @return string\n";
					$fileValue .= "	 */\n";
					$fileValue .= "	public function get".ucfirst($name)."()\n	{\n		return \$this->$name;\n	}\n\n";
			}					
		return $fileValue;
	}
}