<?php
namespace Core\Modules\Shop\Models;
/**
 * CRUD methods for categories.
 * This implementations uses Nested Adjacency list tree model.
 * @author <miloskajnaco@gmail.com>
 * @see Adjacency list
 */
class CategoriesAdjacencyList implements Categories
{
    /**
    * Class constructor.
    * @param object (\PDO)
    */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

	/**
	* Get categories in nested unordered lists.
	* @return string (HTML unordered list made from _category_array($cat_id)
	*/
    public function getCategories()
    {
        // get list of categories from database
        $stmt = $this->conn->prepare('SELECT * FROM categories');
        $stmt->execute();
        $this->cats = $stmt->fetchAll();
        // call recursion starting with root category id
        // root category wont be included in result
        return $this->_category_array(0);
    }
    
    /**
	* Recursive function to make lists from categories.
	* @param int $cat_id
	* @return string
	*/
    private function category_array($cat_id)
    {
        // string to store HTML <ul> and <li> data
        $r = '';
        // get all children of selected category
        $cats = $this->_get_children($cat_id);
        // if there is entries continue
        if (!empty($cats)) {
            $r .= '<ul>';
            foreach ($cats as $c) // iterate through children categories
            {
                // call recursion to check if current category have children also
                $temp = $this->category_array($c['category_id']);
                if($temp!='') {
                    $url = '<div>'.$c['category_name'].'</div>';
                } else {
                    $url = '<a id="'.$c['category_id'].'" href="'.$c['category_id'].'">'.$c['category_name'].
                        '</a>';
                }
                $r .= '<li>'.$url.$temp.'</li>';
            }
            $r .= '</ul>';
        }
        return $r;
    }

    /**
	* Get all children of selected category.
	* @param int
	* @return array
	*/
    private function _get_children($cat_id)
    {
        $r = array();
        foreach ($this->cats as $c) {
           if($c['parent']==$cat_id)
               $r[] = $c;
        }
        return $r;
    }

    /**
    * Insert category.
    * @param string
    * @param int (parrent id)
    */
    public function insertCategory($name, $parent)
    {

    }

    /**
    * Delete category and all of its children.
    * @param int (id of category)
    */
    public function deleteCategory($id)
    {

    }
}