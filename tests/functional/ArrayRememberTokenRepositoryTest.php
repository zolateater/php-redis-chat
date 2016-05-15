<?php
use App\Model\RememberToken;
use App\Store\Repository\ArrayRememberTokenRepository;

/**
 * Created by PhpStorm.
 * User: zolat
 * Date: 15.05.16
 * Time: 14:33
 */
class ArrayRememberTokenRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group Redis
     * @dataProvider getRememberToken
     */
    public function it_stores_auth_token(RememberToken $token)
    {
        $repository = new ArrayRememberTokenRepository();

        $this->assertFalse($repository->exists($token->getTokenValue()));

        $repository->save($token);

        $this->assertTrue($repository->exists($token->getTokenValue()));
        $this->assertEquals($repository->getOwnerId($token->getTokenValue()), $token->getUserId());
    }

    /**
     * @test
     * @expectedException \App\Exception\Application\Repository\TokenDoesNotExistException
     * @param RememberToken $token
     * @dataProvider getRememberToken
     */
    public function it_fails_to_retrieve_a_user_id_if_token_does_not_exist(RememberToken $token)
    {
        $repository = new ArrayRememberTokenRepository();
        $repository->getOwnerId($token->getTokenValue());
    }

    public function getRememberToken()
    {
        return [
            [new RememberToken(rand(100, 999))]
        ];
    }
}