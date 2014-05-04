<?php
namespace Core\Modules\Shop;
/**
* Setup class for Shop module
*/
class Setup extends \Core\Core\BaseController
{
	public function __construct() 
	{
		$this->initDb($this->db());
	}

	/**
	* Function for creating tables needed for shop.
	* @param \PDO
	* @throws PDOException
	*/
	private function initDb($db)
	{
        try {
            $db->getConnection()->beginTransaction();
			// Create table for products
			$params = [
			   'product_id' 	=> 'INT AUTO_INCREMENT NOT NULL',
			   'name'			=> 'varchar(128)',
			   'description'	=> 'varchar(1024)',
			   'qty'			=> 'SMALLINT',
			   'price'			=> 'FLOAT',
			   'category_id'	=> 'INT',
			   'manufacturer_id'=> 'INT',
			   'active'			=> 'BOOLEAN'
			  ];
			if($db->createTable('products', $params))
			echo 'Created products table<br>';
			// Create table for categories
			// Nested set table
			$params = [
			   'category_id'	=> 'INT AUTO_INCREMENT NOT NULL',
			   'category_name'	=> 'varchar(128)',
			   'lft'			=> 'INT',
			   'rgt'			=> 'INT'
			  ];
			// Adjacency list table 
			  /*
	  		$params = [
			   'category_id'	=> 'INT AUTO_INCREMENT NOT NULL',
			   'category_name'	=> 'varchar(128)',
			   'parent_id'		=> 'INT'
			  ];
			  */
			if($db->createTable('categories', $params))
			echo 'Created categories table<br>';
			// Create table for product_reviews
			$params = [
			   'review_id'		=> 'INT AUTO_INCREMENT NOT NULL',
			   'author'			=> 'varchar(128)',
			   'review'			=> 'varchar(1024)',
			   'product_id' 	=> 'INT',
			   'date_created'	=> 'DATETIME',
			   'approved'		=> 'BOOLEAN'
			  ];
			if($db->createTable('product_reviews', $params))
			echo 'Created product_reviews table<br>';
			// Create table for product_images
			$params = [
			   'product_id' 	=> 'INT AUTO_INCREMENT NOT NULL',
			   'path1'			=> 'varchar(128)',
			   'path2'			=> 'varchar(128)',
			   'path3'			=> 'varchar(128)'
			  ];
			if($db->createTable('product_images', $params))
			echo 'Created product_images table<br>';		  
			// Create table for product_ratings
			$params = [
			   'product_id' 	=> 'INT AUTO_INCREMENT NOT NULL',
			   'rating'			=> 'SMALLINT',
			   'count'			=> 'INT'
			  ];
			if($db->createTable('product_rating', $params))
				echo 'Created product_rating table<br>';
			// Create table for product_manufacturers
			$params = [
			   'manufacturer_id'=> 'INT AUTO_INCREMENT NOT NULL',
			   'man_name'		=> 'varchar(128)',
			   'man_desc'		=> 'varchar(256)'
			  ];
			if($db->createTable('product_manufacturers', $params))
				echo 'Created product_manufacturers table<br>';

            $db->getConnection()->commit();
        } catch(PDOException $ex) {
            // If something went wrong rollback!
            $db->getConnection()->rollBack();
            echo $ex->getMessage();
        }   
	}
}