<?php

namespace Dung\Blog\Ui\Component\Listing\Columns;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Thumbnail
 * @package Dung\Blog\Ui\Component\Listing\Columns
 */
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const DIRECTORY_IMAGE = 'blog/images/';
    protected $_storeManager;
    protected $_urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
        $this->_urlBuilder   = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $url       = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . self::DIRECTORY_IMAGE;
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$fieldName . '_src']      = $url . $item['image'];
                $item[$fieldName . '_alt']      = $item['title'];
                $item[$fieldName . '_link']     = $this->_urlBuilder->getUrl('blog/blog/edit', ['id' => $item['id']]);
                $item[$fieldName . '_orig_src'] = $url . $item['image'];
            }
        }
        return $dataSource;
    }

}