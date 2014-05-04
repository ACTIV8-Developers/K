<?php
namespace Core\Modules\Shop\Models;
/**
 * Interface for CRUD functions in categories table.
 * @author <miloskajnaco@gmail.com>
 */
interface Categories
{
    /**
    * Get of descendant of category
    * @param int (category id)
    * @return array
    */
    public function getDescendants($id);

    /**
    * Get all categories with depth value
    * @return array
    */
    public function getCategories();

    /**
    * Delete category and all of its children.
    * @param int (id of category)
    */
    public function deleteCategory($id);

}