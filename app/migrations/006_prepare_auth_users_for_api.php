<?php

class Prepare_auth_users_for_api
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('auth_users')) {
            throw new RuntimeException('The auth_users table is required before applying this migration.');
        }

        if (!$this->_lava->dbforge->column_exists('auth_users', 'role')) {
            $this->_lava->dbforge->add_column('auth_users', [
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => FALSE,
                    'default'    => 'user',
                ],
            ]);
        }

        $this->_lava->dbforge->modify_column('auth_users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
            ],
        ]);

        $users = $this->_lava->db->raw('SELECT id, password FROM auth_users')
                                ->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $password = (string) $user['password'];
            if (password_get_info($password)['algoName'] === 'unknown') {
                $this->_lava->db->raw(
                    'UPDATE auth_users SET password = ? WHERE id = ?',
                    [password_hash($password, PASSWORD_DEFAULT), $user['id']]
                );
            }
        }

        $this->_lava->db->raw(
            "UPDATE auth_users SET role = 'admin' WHERE username = 'admin' AND role = 'user'"
        );
    }

    public function down()
    {
        // Retain the role and password hashes so rollback cannot weaken auth or discard access policy.
    }
}
