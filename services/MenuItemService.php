<?php

namespace sirgalas\menu\services;

use sirgalas\menu\entities\MenuName;
use sirgalas\menu\entities\MenuItem;

class MenuItemService
{

    public function ItemSave($post,$entities){
        $menuName=MenuName::findOne($post['menu']);
        $menuItem= new MenuItem();
        $menuItem->name_table_id=$menuName->id;
        $menuItem->name=$entities->title;
        $menuItem->item_depth=0;
        $menuItem->content=json_encode($this->saveJson($entities));
        if($menuItem->save())
            throw new \RuntimeException(var_dump($menuItem->getErrors()));
    }

    private function saveJson($object){
        $array['object']=$object::className();
        $array['objectAlias']=$object->alias;
        $array['objectId']=$object->id;
        $array['objectTitle']=$object->title;
        return $array;
    }
}