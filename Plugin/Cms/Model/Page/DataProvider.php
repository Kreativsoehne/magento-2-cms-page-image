<?php

namespace KuS\CmsPageImage\Plugin\Cms\Model\Page;

use KuS\CmsPageImage\Model\PageImage;

class DataProvider
{

    protected $_logger;

    protected $_model;

	public function __construct(
		\Psr\Log\LoggerInterface $loggerInterface,
        \KuS\CmsPageImage\Model\PageImageFactory $model,
        \KuS\CmsPageImage\Helper\Data $helper
	) {
		$this->_logger   = $loggerInterface;
        $this->_model    = $model;
        $this->_helper   = $helper;
	}

    public function afterGetData(
        \Magento\Cms\Model\Page\DataProvider $subject,
        //array $data
        $data
    ) {
        if (empty($data) && !is_array($data)) return $data;

        $cmsPageImage = $this->_model->create()->load($this->getPageId($data), 'page_id');

        if (!$cmsPageImage->getImagePath()) return $data;

        $cmsPageImageData = [
                0 => [
                    'name' => basename($cmsPageImage->getImagePath()),
                    'url' => $this->_helper->resize($cmsPageImage->getImagePath(), 500)
                ],
            ];

        $data[$this->getPageId($data)]['page_image'] = $cmsPageImageData;

        //$this->_logger->debug(print_r($data,true));
        //$this->_logger->debug(print_r(get_class_methods($subject),true));
        //$this->_logger->debug(print_r($subject->getCollection(),true));

        return $data;

    }

    protected function getPageId($_data)
    {
        reset($_data);
        return key($_data);
    }

}