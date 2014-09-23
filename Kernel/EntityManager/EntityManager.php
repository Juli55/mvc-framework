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


  function __construct(){

        $db = new DB;
        $this->db  = $db::$db;
        $this->db_user  = $db::$db_user;
    
  }

  public function getConnection(){

    return $this->db;

  }
  
  public function getEntity($entity){

    $entityDir = explode(':',$entity);

    require('../src/'.$entityDir[0].'/Entity/'.$entityDir[1].'.php');

    $entityObject = new $entityDir[1];

    $this->entityObject_name = get_class($entityObject);
    $this->entityObject = $entityObject;
    return $entityObject;

  }

  public function create(){




  }

  public function find($finder,$target){

    $query = "SELECT * FROM $this->db_user.$this->entityObject_name WHERE $finder = $target";
    $request = $this->db->query($query) or die($this->db->error);
    foreach ($request->fetch_assoc() as $key => $value){

      $setter = 'set'.ucfirst($key);
      call_user_func_array(array($this->entityObject,$setter),array($value));

    }

      $this->target = $target;
      $this->finder = $finder;
      $this->entityFirst = (array)$this->entityObject;
      return $this->entityObject;
  }

 public function findAll($finder='',$target=''){
      
      $query   = "SELECT * FROM $this->db_user.$this->entityObject_name";
      $request = $this->db->query($query) or die($this->db->error);
      $result  = array();
      while($row=$request->fetch_assoc())
      {
        $setter = 'set'.ucfirst($key);
        $cloned_EntityObject = clone $this->entityObject;
        call_user_func_array(array($cloned_EntityObject,$setter),array($value));
        $result[]= $cloned_EntityObject;
      } 
      $this->entityFirst = $result;
      return $result;
    /*
    if(empty($finder))
    {
      $query = "SELECT * FROM $this->db_user.$this->entityObject_name";
      $request = $this->db->query($query) or die($this->db->error);
      $result=array();
      while($row=$request->fetch_assoc())
      {
        $result[]=$row;
      } 
      return $result;
    }
    else{

      $query = "SELECT * FROM $this->db_user.$this->entityObject_name WHERE $finder = $target";
      $request = $this->db->query($query) or die($this->db->error);
      while($row=$request->fetch_assoc())
      {
        $result[]=$row;
      }
        foreach ($result as $key => $value) {
          foreach ($value as $key => $val){

            $setter = 'set'.ucfirst($key);
            call_user_func_array(array($this->entityObject,$setter),array($val));
          }
        }

      $this->target = $target;
      $this->finder = $finder;
        $this->entityFirst = (array)$this->entityObject;
        return $this->entityObject;
    }    
     */   
      
  }

  public function flush(){

      $arr = $this->entityFirst;
      $arr2= (array)$this->entityObject;
      $arr_clean = array();
      $arr_clean2 = array();
      
      if(is_object($this->entityFirst)){

      }
      else if(is_array($this->entityFirst)){
        
      }
      
       foreach ($arr as $k => $v) {
        $k = preg_match('/^\x00(?:.*?)\x00(.+)/', $k, $matches) ? $matches[1] : $k;
        $arr_clean[$k] = $v;
        }
        foreach ($arr2 as $k => $v) {
        $k = preg_match('/^\x00(?:.*?)\x00(.+)/', $k, $matches) ? $matches[1] : $k;
        $arr_clean2[$k] = $v;
        }
      foreach ($arr_clean2 as $key => $val) {
        
        if($val !== $arr_clean[$key])
        {          
          echo $this->query = "UPDATE $this->db_user.$this->entityObject_name SET $key = $arr_clean2[$key] WHERE ID = $arr_clean[ID] ";
          $request = $this->db->query($this->query) or die($this->db->error);
        }
      
      }     


  }

}