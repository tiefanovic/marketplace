<?php

namespace AWstreams\Marketplace\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();


        // Shop Information table
        $tableName = $installer->getTable('shop_information');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create emipro_sampletable table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'shop_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn('facebook_id', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'facebook id ')
                ->addColumn('twitter_id', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'twitter id ')
                ->addColumn('youtube_id', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'youtube id ')
                ->addColumn('instagram_id', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'instagram id ')
                ->addColumn('contact_number', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'contact number')
                ->addColumn('tax_number', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'tax number')
                ->addColumn('shop_title', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'Shop title')
                ->addColumn('shop_address', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'address')
                ->addColumn('shop_description', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'Description')
                ->addColumn('shop_description', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'Description')
                ->addColumn('shipping_policy',Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'shipping_policy')
                ->addColumn('return_policy', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'return_policy')
                ->addColumn('country', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'country')
                ->addColumn('shop_logo', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'logo')
                ->addColumn('shop_banner', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'banner')
                ->addColumn('customer_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false, 'unsigned' =>  true], 'customer Id')

                ->addIndex($installer->getIdxName('shop_information',  ['customer_id']), ['customer_id'])
                ->addForeignKey($installer->getFkName('shop_information', 'customer_id', 'customer_entity', 'entity_id'),
                    'customer_id',
                    $installer->getTable('customer_entity'), 'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)

                ->setComment('shop_information Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        // Shop rate table
        $tableName = $installer->getTable('shop_rate');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create emipro_sampletable table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn('price', Table::TYPE_SMALLINT, null, ['nullable' => false, ], 'price ')
                ->addColumn('value', Table::TYPE_SMALLINT, null, ['nullable' => false, ], 'value ')
                ->addColumn('quality', Table::TYPE_SMALLINT, null, ['nullable' => false, ], 'quality  ')
                ->addColumn('name', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'name ')
                ->addColumn('summary', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'summary')
                ->addColumn('review', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'review')
                ->addColumn('approve', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '0'], 'approve')
                ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT], 'review')
                ->addColumn('shop_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false, 'unsigned' =>  true], 'shop_id')

                ->addIndex($installer->getIdxName('shop_rate',  ['shop_id']), ['shop_id'])
                ->addForeignKey($installer->getFkName('shop_rate', 'shop_id', 'shop_information', 'shop_id'),
                    'shop_id',
                    $installer->getTable('shop_information'), 'Shop_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)

                ->setComment('shop_rate Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        // Shop  Contact table
        $tableName = $installer->getTable('shop_contact');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create emipro_sampletable table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn('name', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'name ')
                ->addColumn('email', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'email')
                ->addColumn('subject', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'subject')
                ->addColumn('message', Table::TYPE_TEXT, null, ['nullable' => false, 'default' => ''], 'message')
                ->addColumn('customer_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false, 'unsigned' =>  true], 'customer Id')

                ->addIndex($installer->getIdxName('shop_contact',  ['customer_id']), ['customer_id'])
                ->addForeignKey($installer->getFkName('shop_contact', 'customer_id', 'customer_entity', 'entity_id'),
                    'customer_id',
                    $installer->getTable('customer_entity'), 'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)

                ->setComment('shop_contact Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }



        $installer->endSetup();
    }
}