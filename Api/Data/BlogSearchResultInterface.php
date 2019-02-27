<?php
namespace Dung\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface BlogSearchResultInterface
 * @package Dung\Blog\Api\Data
 */
interface BlogSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get blog list.
     *
     * @return \Dung\Blog\Api\Data\BlogInterface[]
     */
    public function getItems();

    /**
     * Set blog list.
     *
     * @param  \Dung\Blog\Api\Data\BlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}