<?php
/**
 * Created by PhpStorm.
 * User: vandung
 * Date: 27/02/2019
 * Time: 14:51
 */

namespace Dung\Blog\Controller\Adminhtml\Blog;


use Magento\Backend\App\Action;

/**
 * Class Add
 * @package Dung\Blog\Controller\Adminhtml\Blog
 */
class Add extends Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}