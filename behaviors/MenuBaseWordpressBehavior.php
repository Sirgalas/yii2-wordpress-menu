<?php
namespace sirgalas\menu\behaviors;

use yii\base\Behavior;

class MenuBaseWordpressBehavior extends Behavior
{

    public  $nameAlias;

    public $title;
    public $alias;
    public $id;
    public $path;


    public function getTitle(){
        return $this->title;
    }
    
    

    public function getAlias(){
        return $this->alias;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getPath(){
        return $this->path;
    }



}