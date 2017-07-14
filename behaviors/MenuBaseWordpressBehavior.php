<?php


namespace sirgalas\menu\behaviors;

use yii\base\Behavior;

class MenuBaseWordpressBehavior extends Behavior
{
    public $nameModel;
    public $dbName;
    public $idBehavior;
    public $name;
    public $content;
    public $serviceField;
    public $nameServiceField;

    public function getDbName(){
        return $this->dbName;
    }

    public function getBahaviorId(){
        return $this->idBehavior;
    }

    public function getName(){
        return $this->name;
    }

    public function getContent(){
        return $this->content;
    }   
    
    public function getIdMenuBechavior(){
        return $this->idBehavior;
    }

    public function getServiceField(){
        return $this->serviceField;
    }

    public function getNameServiceField(){
        return $this->nameServiceField;
    }

    public function getBase(){
    if(isset($this->dbName)){
        return true;
    }else{
        return $this->dbName;
    }
}
}