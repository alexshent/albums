<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
	public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('user1');

        expect_not(User::findIdentity(999));
    }
    
    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('user10'));
        expect_not(User::findByUsername('user999'));
    }
}
