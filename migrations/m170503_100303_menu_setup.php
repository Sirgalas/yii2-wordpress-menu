<?php

use yii\db\Migration;

class m170503_100303_menu_setup extends Migration
{
    public function up()
    {
        $this->createTable('{{%menu_table}}',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull()->unique(),
            'content'=>$this->text()->notNull()
        ]) ;
    }

    public function down()
    {
        $this->dropTable('menu_table');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
