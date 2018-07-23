<?php

namespace KuS\CmsPageImage\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Model\Page;
use KuS\CmsPageImage\Helper\Data;

/**
 * CmsImage block
 */
class PageImage extends \Magento\Framework\View\Element\Template
{
    protected $_page;

    protected $_helper;

    protected $_model;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Page $page,
        \KuS\CmsPageImage\Helper\Data $helper,
        \KuS\CmsPageImage\Model\PageImageFactory $model, // Instanz über Factory
        //\KuS\CmsPageImage\Model\PageImage $model, //als direkte Model-Instanz
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_page    = $page;
        $this->_helper  = $helper;
        $this->_model   = $model;
    }

    public function getPageImageUrl()
    {
        $data = $this->_model->create()->load($this->_page->getId(), 'page_id'); // Nutzung über Factory
        //$data = $this->_model->load($this->_page->getId(), 'page_id'); // Nutzung direkter Instanz

        if (!$data->getImagePath()) return false;

        return $this->_helper->resize($data->getImagePath(), 2560);
    }

}
