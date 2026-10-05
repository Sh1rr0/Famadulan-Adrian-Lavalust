<?php

class Add_product_category
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (
            $this->_lava->dbforge->table_exists('products')
            && !$this->_lava->dbforge->column_exists('products', 'category')
        ) {
            $this->_lava->dbforge->add_column('products', [
                'category' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => TRUE,
                ],
            ]);
        }
    }

    public function down()
    {
        // Keep product categories when rolling back this compatibility migration.
    }
}
