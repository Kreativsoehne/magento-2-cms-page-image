<?php
namespace KuS\CmsPageImage\Model\ResourceModel\PageImage;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
    $this->_init(
        'KuS\CmsPageImage\Model\PageImage',
        'KuS\CmsPageImage\Model\ResourceModel\PageImage'
    );

    }
}