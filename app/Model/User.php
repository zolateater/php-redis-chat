<?php
/**
 * Created by PhpStorm.
 * User: zolat
 * Date: 23.04.16
 * Time: 15:57
 */

namespace App\Model;

/**
 * Class User
 * @package App\Model
 *
 * User model class
 */
class User extends Model
{
    /**
     * Login of the user
     * 
     * @var string
     */
    protected $login;

    /**
     * Full name of the user
     *
     * @var string
     */
    protected $fullName;

    /**
     * User constructor.
     * @param string $login
     * @param string $fullName
     */
    public function __construct(string $login, string $fullName)
    {
        $this->login = $login;
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getLogin() : string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }
}