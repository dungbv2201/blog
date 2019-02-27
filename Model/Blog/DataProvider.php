<?php

namespace Dung\Blog\Model\Blog;

use Dung\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package Dung\Blog\Model
 */
class DataProvider extends AbstractDataProvider
{
    protected $_loadedData;

    protected $_dataPersistor;

    protected $_storeManager;

    protected $directory;

    protected $collection;

    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $blogCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param DirectoryList $directoryList
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blogCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        DirectoryList $directoryList,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection     = $blogCollectionFactory->create();
        $this->_dataPersistor = $dataPersistor;
        $this->_storeManager  = $storeManager;
        $this->directory      = $directoryList;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items         = $this->collection->getItems();
        $fileImagePath = $this->directory->getPath('media').'/blog/images/';

        foreach ($items as $blog) {
            $data      = $blog->getData();
            $imageName = $data['image'];
            unset($data['image']);
            $data['image'][0]['url']  = $this->_storeManager
                    ->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'blog/images/' . $imageName;
            $data['image'][0]['name'] = $imageName;
            $data['image'][0]['size'] = filesize($fileImagePath. $imageName);
            $this->_loadedData[$blog->getId()] = $data;


        }
        $data = $this->_dataPersistor->get('blog');
        if (!empty($data)) {
            $blog = $this->collection->getNewEmptyItem();
            $blog->setData($data);
            $this->_loadedData[$blog->getData('id')] = $blog->getData();
            $this->_dataPersistor->clear('blog');
        }
        return $this->_loadedData;
    }
}