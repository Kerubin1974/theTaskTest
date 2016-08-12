<?php

use yii\db\Migration;

class m160812_061732_create_tables extends Migration
{
    public function up()
    {
        $this->createTable('plans', [
            'id' => 'pk',
            'plan_id' => 'integer NOT NULL',
            'name' => 'string',
            'group' => 'integer',
            'active_from' => 'integer',
            'active_to' => 'integer'
        ]);
        $this->createTable('properties', [
            'id' => 'pk',
            'property_id' => 'integer NOT NULL',
            'type' => 'integer',
            'plan_id' => 'integer NOT NULL',
            'active_from' => 'integer',
            'active_to' => 'integer',
            'value' => 'string'
        ]);
        $this->createIndex('FK_properties_plan', 'properties', 'plan_id');
    }

    public function down()
    {
        echo "m160812_061732_create_tables cannot be reverted.\n";
        $this->dropTable('plans');
        $this->dropTable('properties');
        return false;
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
