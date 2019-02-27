<?php

namespace Dung\Blog\Controller\Adminhtml\Blog;


use Dung\Blog\Api\BlogRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;


/**
 * Class Edit
 * @package Dung\Blog\Controller\Adminhtml\Blog
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    protected $blogRepository;

    protected $blogModel;
    /**
     * @var string $title
     */
    protected $title = 'Add New Blog';
    protected $_registry;

    public function __construct(Action\Context $context,
                                PageFactory $pageFactory,
                                BlogRepositoryInterface $blogRepository,
                                Registry $registry
    )
    {
        $this->blogRepository = $blogRepository;
        $this->pageFactory    = $pageFactory;
        $this->_registry      = $registry;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $id         = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $data =$this->blogRepository->getById($id);
                $title       = $data->getData('title');
                $this->title = 'Edit Blog: ' . $title;
            } catch (\Exception $exception) {
                $this->getMessageManager()->addErrorMessage(__('This blog no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }
        $this->_setActiveMenu("Dung_Blog::blog");
        $resultPage->getConfig()->getTitle()->prepend(__($this->title));
        return $resultPage;
    }

}