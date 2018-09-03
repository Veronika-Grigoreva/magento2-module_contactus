<?php

namespace Test\Form\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

/**
 * Class InstallSchema
 * @package Test\Form\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $schemaSetup
     * @param ModuleContextInterface $moduleContext
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $schemaSetup,
        ModuleContextInterface $moduleContext
    ) {
        $installer = $schemaSetup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('emails')
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary'  => true
            ],
            'Email ID'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
        )->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Email'
        )->addColumn(
            'subject',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Subject'
        )->addColumn(
            'message',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'Message'
        );

        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
