<?php
namespace Core\Modules\Shop;
/**
* Shop modul main class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Shop extends \Core\Core\BaseController
{

	public function __construct()
	{
		$this->products = new \Core\Modules\Shop\Models\Products($this->db()->getConnection());
		$this->categories = new \Core\Modules\Shop\Models\CategoriesNestedSets($this->db()->getConnection()); 
	}
	// Products
	public function getProducts($perpage, $start, $category_id)
	{
		return $this->products->getProducts($perpage, $start, $category_id);
	}

	public function getProduct($product_id)
	{
		return $this->products->getProduct($product_id);
	}

	public function countProducts($cat_id)
	{
		return $this->products->countProducts($cat_id);
	}
	// Categories
	public function getDescendants($id)
	{
		return $this->categories->getDescendants($id);
	}

	public function getCategories($asList = false)
	{
		$cats = $this->categories->getCategories();
		if($asList) {

		}
		return $cats;
	}

	public function insertCategory($name, $parent)
	{
		$this->categories->insertCategory($name, $parent);
	}

	public function deleteCategory($id)
	{
		$this->categories->deleteCategory($id);
	}
}