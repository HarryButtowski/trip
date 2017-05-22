<?php

use yii\db\Migration;

class m170521_043717_add_auth_key_and_access_token extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'auth_key', 'VARCHAR(255)');
        $this->addColumn('user', 'access_token', 'VARCHAR(255)');
    }

    public function down()
    {
        $this->dropColumn('user', 'access_token');
        $this->dropColumn('user', 'auth_key');
    }
}
