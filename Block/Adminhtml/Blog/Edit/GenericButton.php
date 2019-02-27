<?php

namespace Dung\Blog\Block\Adminhtml\Blog\Edit;

use Dung\Blog\Api\BlogRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    protected $collectionFactory;
    protected $blogRepository;

    public function __construct(
        Context $context,
        BlogRepositoryInterface $blogRepository
    )
    {
        $this->context            = $context;
        $this->blogRepository  = $blogRepository;
    }


    public function getBannerId()
    {
        try {
            return $this->blogRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }

        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
