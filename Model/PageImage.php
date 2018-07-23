<?php
 
namespace KuS\CmsPageImage\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\Filesystem\DirectoryList;

class PageImage extends AbstractModel
{
    /**
     * @todo move to config value
     */
    const UPLOAD_DIR = 'cms';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('KuS\CmsPageImage\Model\ResourceModel\PageImage');
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // bad code, I know :(
    }

    /**
     * Save image data and move uploaded temporary image file to it's
     * destination folder
     */
    public function savePageImage($_imageData, $_pageId, $_storeId)
    {

        /*
            check if there's already an entry for this page and set image id to
            perform update on existing row instead of inserting a new one
        */
        $collection = $this->getCollection()
            ->addFieldToFilter('page_id', array('eq' => $_pageId))
            ->addFieldToFilter('store_id', array('eq' => $_storeId))
            ->addFieldToSelect('image_id')
            ->getFirstItem()
        ;
        if($collection->getImageId()) {

            $this->setImageId($collection->getImageId());
        }

        // set page image data
        $this->setImagePath(basename($_imageData['file']));
        $this->setStoreId($_storeId);
        $this->setPageId($_pageId);
        $this->setIsActive(1);
        $this->save();

        // move image file from temporary to final folder
        $fileIo         = $this->objectManager->get('Magento\Framework\Filesystem\Io\File');
        $mediaDirectory = $this->objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA);
        $source         = $mediaDirectory->getAbsolutePath($_imageData['file']);
        $destination    = $mediaDirectory->getAbsolutePath(self::UPLOAD_DIR . "/") . uniqid(). "_" . basename($_imageData['file']);
        $fileIo->mv($source, $destination);
    }

    /*public function getPageImage*/

}