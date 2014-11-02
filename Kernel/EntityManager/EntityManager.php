<?php

namespace Kernel\EntityManager;

use Kernel\DataBase\DB;

/**
 * @author Dennis Eisele  <dennis.eisele@online.de>
 * @author Julian Bertsch  <Julian.Bertsch42@gmail.com>
 */
class EntityManager{

  /** 
     * @var DB 
     */
  private $db;

  /** 
     * @var DB 
     */
  private $db_user;

  /** 
     * @var string
     */
  private $entityObject_name;

  /** 
     * @var object
     */
  private $entityObject;

  /** 
     * @var object
     */
  private $entityFirst;


  function __construct()
  {

        $db = new DB;
        $this->db  = $db::$db;
        $this->db_user  = $db::$db_user;
  }

  public function getConnection()
  {

    return $this->db;

  }
  
  public function getEntity($entity)
  {

    $entityDir = explode(':',$entity);
    $entityObjectNS =  '\\src\\'.$entityDir[0].'\\Entity\\'.$entityDir[1];
    $entityObject = new $entityObjectNS;
    $this->entityObject_name =  $entityDir[1];
    $this->entityObject = $entityObject;
    return $entityObject;

  }

  public function persist($entity)
  {

    $entityObject = (array)$entity;
    foreach ($entityObject as $k => $v){
    $k = preg_match('/^\x00(?:.*?)\x00(.+)/', $k, $matches) ? $matches[1] : $k;
    $entityObject_clean[$k] = $v;
    }
    $all_keys = '';
    $all_values = '';
    foreach ($entityObject_clean as $key => $value) {
     if(is_null($value))
     {
      $value= '0'; 
     }
     if(is_int($value))
     {
      $value = (string)$value;
     }
     $all_values = $all_values.","."'".$value."'";
     $all_keys = $all_keys.",".$key;
     $all_values = ltrim($all_values,',');
     $all_keys = ltrim($all_keys,',');
    }
      $this->query = "INSERT INTO $this->db_user.$this->entityObject_name($all_keys) VALUES($all_values)";

  }

  public function find($finder,$target)
  {

    $query = "SELECT * FROM $this->db_user.$this->entityObject_name WHERE $finder = '$target'";
    $request = $this->db->query($query) or die($this->db->error);
    if($request->num_rows){
  
      foreach ($request->fetch_assoc() as $key => $value){

        $setter = 'set'.ucfirst($key);
        call_user_func_array(array($this->entityObject,$setter),array($value));

      }

        $entityFirst = (array)$this->entityObject;
        foreach ($entityFirst as $k => $v){
            $k = preg_match('/^\x00(?:.*?)\x00(.+)/', $k, $matches) ? $matches[1] : $k;
            $entityFirst_clean[$k] = $v;
        }
        $this->entityFirst = $entityFirst_clean;
        return $this->entityObject;
    }
  }

 public function findAll($finder='',$target='')
 {
      if(empty($finder))
      {
        $query = "SELECT * FROM $this->db_user.$this->entityObject_name";
      }else{
        $query = "SELECT * FROM $this->db_user.$this->entityObject_name WHERE $finder = '$target'";
      }

      $request = $this->db->query($query) or die($this->db->error);

      $entityObject_clean = array();
      $entityFirst = array();
      $entityObject = array();
      while($row=$request->fetch_assoc())
      {
        $cloned_EntityObject = clone $this->entityObject;
        foreach ($row as $key => $value){
          $setter = 'set'.ucfirst($key);

          call_user_func_array(array($cloned_EntityObject,$setter),array($value));
        }
        
        foreach ((array)$cloned_EntityObject as $key => $value) {
          $key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
          $entityObject_clean[$key] = $value;
        }
        $entityFirst[]  = $entityObject_clean;
        $entityObject[] = $cloned_EntityObject;
      }

      $this->entityFirst  = $entityFirst;
      $this->entityObject = $entityObject;
      return $this->entityObject;      
  }

  public function flush()
  {

      $entityFirst = $this->entityFirst;

      if(!empty($this->query))
      {
        $request = $this->db->query($this->query) or die ($this->db->error);
      }
      elseif(is_object($this->entityObject)){

          $entityObject = (array)$this->entityObject;
        foreach ($entityObject as $k => $v) {
            $k = preg_match('/^\x00(?:.*?)\x00(.+)/', $k, $matches) ? $matches[1] : $k;
            $entityObject_clean[$k] = $v;
        }

        foreach ($entityObject_clean as $key => $val) {
              
              if($val !== $entityFirst[$key]){
          
  
                $query = "UPDATE $this->db_user.$this->entityObject_name SET $key = '$entityObject_clean[$key]' WHERE ID = $entityObject_clean[ID] ";
                $request = $this->db->query($query) or die($this->db->error);
              
              }
      
        }     

      }elseif(is_array($this->entityObject)){

        $entityObject = array();
        foreach($this->entityObject as $key => $value){
          $entityObject_clean = array();
          foreach ((array)$value as $key => $value) {
            $key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
            $entityObject_clean[$key] = $value;
          }
          $entityObject[] = $entityObject_clean;
        }
        foreach ($entityFirst as $key => $value) {
            foreach($value as $key2 => $value2){
              if($value2 !== $entityObject[$key][$key2]){
                $query = "UPDATE $this->db_user.$this->entityObject_name SET $key2 = '".$entityObject[$key][$key2]."' WHERE ID = ".$value['ID'];
                $request = $this->db->query($query) or die($this->db->error);
              }
            }
        }           
    }
  }
}