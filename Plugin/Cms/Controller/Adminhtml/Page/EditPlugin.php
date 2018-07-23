<?php

namespace KuS\CmsPageImage\Plugin\Cms\Controller\Adminhtml\Page;

class EditPlugin
{

	protected $logger;
 
	public function __construct(
		\Psr\Log\LoggerInterface $loggerInterface
	) {
		$this->logger = $loggerInterface;
	}


    public function aroundExecute(
        \Magento\Cms\Controller\Adminhtml\Page\Edit $subject,
        \Closure $proceed
    ) {
        //$this->logger->debug('debug1234');

        return $proceed();
    }

    /**
     * Get form HTML
     *
     * @return string
     */
    public function aroundGetFormHtml(
        \Magento\Cms\Block\Adminhtml\Page $subject,
        \Closure $proceed
    )
    {

        $this->logger->debug('Edit_aroundGetFormHtml');

        $form = $subject->getForm();
        if (is_object($form)) {
            $fieldset = $form->addFieldset('admin_user_image', ['legend' => __('User Image')]);
            $fieldset->addField(
                'user_image',
                'image',
                [
                    'name' => 'user_image',
                    'label' => __('Image'),
                    'id' => 'user_image',
                    'title' => __('Image'),
                    'required' => false,
                    'note' => 'Allow image type: jpg, jpeg, png'
                ]
            );

            $subject->setForm($form);
        }

        return $proceed();
    }

}