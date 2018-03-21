<?php

use yii\db\Migration;

class m170503_100303_menu_setup extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%menu_name}}',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull()->unique(),
            'parent_id' =>$this->integer(),
            'created_at'=>$this->dateTime(),
            'updated_at'=>$this->dateTime()
        ]) ;
        $this->createTable('{{%menu_item}}',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'name_table_id'=>$this->integer()->notNull(),
            'parent_id'=>$this->integer(),
            'content'=>'JSON',
            'item_depth'=>$this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu_name}}');
        $this->dropTable('{{%menu_item}}');
    }

}
