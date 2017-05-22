<?php

use yii\db\Migration;

class m170519_012303_install extends Migration
{
    public function safeUp()
    {
        $this->createTable('department', [
            'id BIGSERIAL NOT NULL PRIMARY KEY',
            'name VARCHAR(255) NOT NULL',
        ]);
        $this->createTable('organization', [
            'id BIGSERIAL NOT NULL PRIMARY KEY',
            'city_id BIGINT NOT NULL',
            'name VARCHAR(255) NOT NULL',
        ]);
        $this->createTable('city', [
            'id BIGSERIAL NOT NULL PRIMARY KEY',
            'name VARCHAR(255) NOT NULL',
        ]);
        $this->createTable('user', [
            'id BIGSERIAL NOT NULL PRIMARY KEY',
            'department_id BIGINT NOT NULL',
            'surname VARCHAR(255) NOT NULL',
            'name VARCHAR(255) NOT NULL',
            'patronymic VARCHAR(255) NOT NULL',
            'login VARCHAR(255) NOT NULL',
            'password VARCHAR(255) NOT NULL',
        ]);
        $this->createTable('trip', [
            'id BIGSERIAL NOT NULL PRIMARY KEY',
            'user_id BIGINT NOT NULL',
            'organization_id BIGINT NOT NULL',
            'date_start BIGINT NOT NULL',
            'date_end BIGINT NOT NULL',
            'expenses JSONB',
        ]);


        $this->addForeignKey('fk_user_department_id', 'user', 'department_id', 'department', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_organization_city_id', 'organization', 'city_id', 'city', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_trip_user_id', 'trip', 'user_id', 'user', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk_trip_organization_id', 'trip', 'organization_id', 'organization', 'id', "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_trip_organization_id', 'trip');
        $this->dropForeignKey('fk_trip_organization_id', 'trip');
        $this->dropForeignKey('fk_organization_city_id', 'organization');
        $this->dropForeignKey('fk_user_department_id', 'user');

        $this->dropTable('trip');
        $this->dropTable('user');
        $this->dropTable('city');
        $this->dropTable('organization');
        $this->dropTable('department');
    }
}
