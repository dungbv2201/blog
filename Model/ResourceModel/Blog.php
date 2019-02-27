<?php
/**
 * Created by PhpStorm.
 * User: vandung
 * Date: 27/02/2019
 * Time: 11:43
 */

namespace Dung\Blog\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Blog
 * @package Dungbv\Blog\Model\ResourceModel
 */
class Blog extends AbstractDb
{
    public function _construct()
    {
        $this->_init('blog','id');
    }
}