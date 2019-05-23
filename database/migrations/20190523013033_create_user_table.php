<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUserTable extends Migrator
{

    public function up()
    {
        $table = $this->table('user', array('engine' => 'InnoDB'));
        $table->addColumn('user_code', 'string', array('limit' => 15, 'default'=>'', 'comment' => '用户登录名'))
            ->addColumn('password', 'string', array('limit' => 32, 'default' => md5('123456'), 'comment' => '用户密码'))
            ->addColumn('user_name', 'string', array('limit' => 32, 'default'=>'', 'comment' => '用户姓名'))
            ->addColumn('gender', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '性别'))
            ->addColumn('photo', 'string', array('limit' => 32, 'default' => '', 'comment' => '用户头像'))
            ->addColumn('token', 'string', array('limit' => 32, 'default' => '', 'comment' => '令牌'))
            ->addColumn('status', 'integer', array('limit' => 11, 'default' => 1, 'comment' => '1-正常，-1-已删除，2-禁用'))
            ->addTimestamps()
            ->addIndex(array('id'), array('unique' => true))
            ->create();
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
