<?php

namespace Dung\Blog\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;


/**
 * Class InstallSchema
 * @package Dungbv\Blog\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return string|void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $tableName = $installer->getTable("blog");
        $conn = $installer->getConnection();
        if(!$conn->isTableExists($tableName)){
            try{
                $table = $conn->newTable($tableName)
                    ->addColumn(
                        'id',
                        Table::TYPE_INTEGER,
                        null,
                        ['identity'=>true,'primary'=>true,'nullable'=>false,'unsigned'=>true]
                    )
                    ->addColumn(
                        'store_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['nullable'=>false,'unsigned'=>true]
                    )
                    ->addColumn(
                        'title',
                        Table::TYPE_TEXT,
                        72,
                        ['nullable'=>true]
                    )
                    ->addColumn(
                        'slug',
                        Table::TYPE_TEXT,
                        null,
                        ['nullable'=>true,'unique'=>true,]
                    )
                    ->addColumn(
                        'description',
                        Table::TYPE_TEXT,
                        500,
                        ['nullable'=>true]
                    )
                    ->addColumn(
                        'content',
                        Table::TYPE_TEXT,
                        '64k',
                        ['nullable'=>false]
                    )
                    ->addColumn(
                        'image',
                        Table::TYPE_TEXT,
                        255,
                        ['nullable'=>true]
                    )
                    ->addColumn(
                        'start_date',
                        Table::TYPE_DATETIME,
                        null,
                        ['nullable'=>true]
                    )
                    ->addColumn(
                        'end_date',
                        Table::TYPE_DATETIME,
                        null,
                        ['nullable'=>true]
                    )
                    ->addColumn(
                        'created_at',
                        Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false,'default'=>Table::TIMESTAMP_INIT]
                    )
                    ->addColumn(
                        'updated_at',
                        Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false,'default'=>Table::TIMESTAMP_INIT_UPDATE]
                    )
                    ->addForeignKey(
                        $installer->getFkName('blog', 'store_id', 'store', 'store_id'),
                        'store_id',
                        $installer->getTable('store'),
                        'store_id',
                        Table::ACTION_NO_ACTION
                    )
                    ->addIndex(
                        $setup->getIdxName(
                            $installer->getTable('blog'),
                            ['title'],
                            AdapterInterface::INDEX_TYPE_FULLTEXT
                        ),
                        ['title'],
                        AdapterInterface::INDEX_TYPE_FULLTEXT
                    )
                    ->setOption('charset','utf8');
                $conn->createTable($table);
            }catch (\Zend_Db_Exception $e){
                $e->getMessage();
            }
        }
        $installer->endSetup();
    }
}