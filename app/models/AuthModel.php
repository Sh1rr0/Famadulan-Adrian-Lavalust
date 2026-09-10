<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthModel extends Model
{
    protected $table = 'auth_users';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function findByUsername($username)
    {
        return $this->find_by('username', $username);
    }
}