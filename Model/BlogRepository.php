<?php
/**
 * Created by PhpStorm.
 * User: vandung
 * Date: 27/02/2019
 * Time: 11:42
 */

namespace Dung\Blog\Model;


use Dung\Blog\Api\BlogRepositoryInterface;
use Dung\Blog\Api\Data\BlogInterface;
use Dung\Blog\Api\Data\BlogSearchResultInterfaceFactory;
use Dung\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class BlogRepository
 * @package Dung\Blog\Model
 */
class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var ResourceModel\Blog
     */
    protected $blogResource;
    /**
     * @var BlogFactory
     */
    protected $blogModel;
    /**
     * @var CollectionFactory
     */
    protected $collection;
    /**
     * @var CollectionProcessor
     */
    protected $collectionProcessor;
    /**
     * @var BlogSearchResultInterfaceFactory
     */
    protected $blogSearchResult;

    /**
     * BlogRepository constructor.
     * @param StoreManagerInterface $storeManager
     * @param ResourceModel\Blog $blogResource
     * @param BlogFactory $blogModel
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessor $collectionProcessor
     * @param BlogSearchResultInterfaceFactory $blogSearchResultInterface
     */
    public function __construct(StoreManagerInterface $storeManager,
                                \Dung\Blog\Model\ResourceModel\Blog $blogResource,
                                BlogFactory $blogModel,
                                CollectionFactory $collectionFactory,
                                CollectionProcessor $collectionProcessor,
                                BlogSearchResultInterfaceFactory $blogSearchResultInterface
    )
    {
        $this->storeManager        = $storeManager;
        $this->blogResource        = $blogResource;
        $this->blogModel           = $blogModel;
        $this->collection          = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->blogSearchResult    = $blogSearchResultInterface;
    }

    /**
     * @param BlogInterface $blog
     * @return mixed
     */
    public function save(BlogInterface $blog)
    {
        if (empty($blog->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $blog->setStoreId($storeId);
        }
        try {
            $this->blogResource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the Blog: %1', $exception->getMessage()),
                $exception
            );
        }
        return $blog;

    }

    /**
     * @param $blogId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($blogId)
    {
        $blog = $this->blogModel->create();
        $blog->load($blogId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Banner with id "%1" does not exist.', $blogId));
        }
        return $blog;

    }

    /**
     * @param $blogId
     * @return bool|mixed
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($blogId)
    {
        return $this->delete($this->getById($blogId));
    }

    /**
     * @param BlogInterface $blog
     * @return bool|mixed
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog)
    {
        try {
            $this->blogResource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the blog: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {

        $collection = $this->collection->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->blogSearchResult->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}