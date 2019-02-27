<?php
/**
 * Created by PhpStorm.
 * User: vandung
 * Date: 27/02/2019
 * Time: 13:08
 */

namespace Dung\Blog\Api\Data;

/**
 * Interface BlogInterface
 * @package Dung\Blog\Api\Data
 */
interface BlogInterface
{
    const Blog_ID        = 'id';
    const Blog_ID_RQ     = 'id';
    const TITLE          = 'title';
    const STORE_ID       = 'store_id';
    const CONTENT        = 'content';
    const DESCRIPTION    = 'description';
    const IMAGE          = 'image';
    const URI_PATH_INDEX = 'blog/blog/index';
    const URI_PATH_ADD   = 'blog/blog/add';
    const URI_PATH_Edit  = 'blog/blog/edit';

}