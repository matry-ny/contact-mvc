<?php

namespace models;

use components\Model;
use components\web\Authorizable;

/**
 * Class User
 * @package models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $auth_token
 * @property int $is_admin
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Model implements Authorizable
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $attributes = [
        'id' => null,
        'name' => null,
        'email' => null,
        'password' => null,
        'auth_token' => null,
        'is_admin' => null,
        'created_at' => null,
        'updated_at' => null
    ];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $token
     */
    public function setAuthToken($token)
    {
        $this->load(['auth_token' => $token]);
        $this->save();
    }

    /**
     * @return string
     */
    public function getAuthToken()
    {
        return $this->auth_token;
    }

    /**
     * @return bool
     */
    public function getIsAdmin()
    {
        return true === (bool)$this->is_admin;
    }
}
