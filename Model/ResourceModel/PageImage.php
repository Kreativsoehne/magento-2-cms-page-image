<?php
 
namespace KuS\CmsPageImage\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
class PageImage extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('kus_cms_page_image', 'image_id');
    }
}