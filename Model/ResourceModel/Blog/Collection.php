<?php
namespace Dung\Blog\Model\ResourceModel\Blog;


use Dung\Blog\Model\Blog;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Dung\Blog\Model\ResourceModel\Blog
 */
class Collection extends AbstractCollection
{
    public  function _construct()
    {
        $this->_init(Blog::class,\Dung\Blog\Model\ResourceModel\Blog::class);
    }
}