<?php

namespace KuS\CmsPageImage\Plugin\Cms\Controller\Adminhtml\Page;

use KuS\CmsPageImage\Model\PageImage;

class Save
{

	protected $logger;

    protected $request;

    protected $model;

	public function __construct(
		\Psr\Log\LoggerInterface $loggerInterface,
        \Magento\Framework\App\Request\Http $request,
        \KuS\CmsPageImage\Model\PageImageFactory $modelFactory,
        \Magento\Cms\Model\Page $page
	) {
		$this->logger   = $loggerInterface;
        $this->request  = $request;
        $this->model    = $modelFactory->create();
	}

    /*
    [page_image] => Array
    (
        [0] => Array
            (
                [name] => Produktion_1.jpg
                [type] => image/jpeg
                [error] => 0
                [size] => 71337
                [file] => /p/r/produktion_1.jpg
                [url] => https://cdn.domain.com/media/tmp/catalog/product/p/r/produktion_1.jpg
            )

    )
    */
    public function beforeExecute(
        \Magento\Cms\Controller\Adminhtml\Page\Save $subject
    ) {
        $data       = $this->request->getPostValue();

        if (!array_key_exists("page_image", $data)) return;

        $imageData  = $data["page_image"][0];
        $this->model->savePageImage($imageData, $this->request->getParam('page_id'), 0);
        //$this->logger->debug(print_r($imageData,true));
    }
}