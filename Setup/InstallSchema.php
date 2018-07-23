<?php
/**
 * Copyright © Kreativ&Söhne GmbH
 */

namespace KuS\CmsPageImage\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Cms\Model\ResourceModel\Page;

/**
 * Class InstallSchema adds new table `kus_cms_page_image`
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * CMS Page Image Table name
     */
    const CMS_PAGE_IMAGE_TABLE = 'kus_cms_page_image';

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $contextInterface)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
        ->newTable($setup->getTable(self::CMS_PAGE_IMAGE_TABLE))
        ->addColumn(
            'image_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'identity' => true, 'nullable' => false, 'primary' => true],
            'Image ID'
        )
        ->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Store ID'
        )
        ->addColumn(
            'page_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Page ID'
        )
        ->addColumn(
            'image_path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'Image Path'
        )
        ->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Image Active'
        )
        ->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Page Creation Time'
        )
        ->addIndex(
            $setup->getIdxName(
                self::CMS_PAGE_IMAGE_TABLE,
                ['image_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['image_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
        )
        ->addForeignKey(
            $setup->getFkName(
                self::CMS_PAGE_IMAGE_TABLE,
                'page_id',
                $setup->getTable('cms_page'),
                'page_id'
            ),
            'page_id',
            $setup->getTable('cms_page'),
            'page_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )
        ->addForeignKey(
            $setup->getFkName(
                self::CMS_PAGE_IMAGE_TABLE,
                'store_id',
                $setup->getTable('store'),
                'store_id'
            ),
            'store_id',
            $setup->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );

        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}