<?php
/**
 * Created by PhpStorm.
 * User: vandung
 * Date: 27/02/2019
 * Time: 13:07
 */

namespace Dung\Blog\Api;

/**
 * Interface BlogRepositoryInterface
 * @package Dung\Blog\Api
 */
interface BlogRepositoryInterface
{
    /**
     * @param \Dung\Blog\Api\Data\BlogInterface $blog
     * @return mixed
     */
    public function save(\Dung\Blog\Api\Data\BlogInterface $blog);

    /**
     * @param $blogId
     * @return mixed
     */
    public function getById($blogId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param $blogId
     * @return mixed
     */
    public function deleteById($blogId);

    /**
     * @param Data\BlogInterface $blog
     * @return mixed
     */
    public function delete(\Dung\Blog\Api\Data\BlogInterface $blog);
}