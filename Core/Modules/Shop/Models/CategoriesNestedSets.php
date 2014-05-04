<?php
namespace Core\Modules\Shop\Models;
/**
 * CRUD methods for categories.
 * This implementations uses Nested Sets tree model which 
 * is good for MySQL database since it doesnt have
 * natural support for recursion, for other databases
 * that support recurions Adjacency list model is prefered.
 * @author <miloskajnaco@gmail.com>
 * @see Nested sets
 */
class CategoriesNestedSets implements Categories
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
    * Get of descendant of category
    * @param int (category id)
    * @return array
    */
    public function getDescendants($id)
    {
        $stmt = $this->conn->prepare("SELECT parent.category_name, parent.category_id
                    FROM categories AS node,
                    categories AS parent
                    WHERE node.lft BETWEEN parent.lft AND parent.rgt
                    AND node.category_id = :id
                    ORDER BY parent.lft");
        $stmt->execute(['id' => $category_id]);
        return $stmt->fetchAll();
    }


    /**
    * Get all categories with depth value
    * @return array
    */
    public function getCategories()
    {
    	$stmt = $this->conn->prepare("SELECT node.category_name, node.category_id, (COUNT(parent.category_name) - 1) AS depth
				FROM categories AS node,
				categories AS parent
				WHERE node.lft BETWEEN parent.lft AND parent.rgt
				GROUP BY node.category_name
				ORDER BY node.lft");
        $stmt->execute();
        $cats = $stmt->fetchAll();
        // Make lists
        $cnt = 0;
        $prev = -1;
        $list = '';
        foreach($cats as $c) {
            if($c['depth']>$prev) {
                $list .= '<ul>';
            } else if($c['depth']<$prev) {
                $list .= '</ul>';
            }
            $list .= '<li>';
            if(0===$c['depth'])
                $list .= '<div>'.$c['category_name'].'</div>';
            else
                $list .= '<a href="'.$c['category_id'].'">'.$c['category_name'].'</a>';
            $prev = $c['depth'];
            $list .= '</li>';
        }
        $list .= '';
        return $list;
    }

    /**
    * Insert category.
    * @param string
    * @param int (parent id)
    */
    public function insertCategory($name, $after)
    {
        try {
            $this->conn->beginTransaction();
            $stmt = null;
            if($hasChild) {
            	$stmt = $this->conn->prepare("LOCK TABLE categories WRITE;
        				SELECT @myRight := rgt FROM categories
        				WHERE category_id = :after;
        				UPDATE categories SET rgt = rgt + 2 WHERE rgt > @myRight;
        				UPDATE categories SET lft = lft + 2 WHERE lft > @myRight;
        				INSERT INTO categories(category_name, lft, rgt) VALUES(:name, @myRight + 1, @myRight + 2);
        				UNLOCK TABLES");
            } else {
                $stmt = $this->conn->prepare("LOCK TABLE categories WRITE;
                        SELECT @myLeft := lft FROM categories
                        WHERE category_id = :after;
                        UPDATE categories SET rgt = rgt + 2 WHERE rgt > @myLeft;
                        UPDATE categories SET lft = lft + 2 WHERE lft > @myLeft;
                        INSERT INTO categories(category_name, lft, rgt) VALUES(:name, @myLeft + 1, @myLeft + 2);
                        UNLOCK TABLES");
            }
            $stmt->execute(['name' => $name, 'after' => $after]);
            $this->conn->commit();
        } catch(PDOException $ex) {
            // If something went wrong rollback!
            $this->conn->rollBack();
            echo $ex->getMessage();
        }   
    }

    /**
    * Delete category and all of its children.
    * @param int (id of category)
    */
    public function deleteCategory($id)
    {
        try {
            $this->conn->beginTransaction();
        	$stmt = $this->conn->prepare("LOCK TABLE categories WRITE;
    				SELECT @myLeft := lft, @myRight := rgt, @myWidth := rgt - lft + 1
    				FROM categories
    				WHERE category_id = :id;
    				DELETE FROM categories WHERE lft BETWEEN @myLeft AND @myRight;
    				UPDATE categories SET rgt = rgt - @myWidth WHERE rgt > @myRight;
    				UPDATE categories SET lft = lft - @myWidth WHERE lft > @myRight;
    				UNLOCK TABLES");
            $stmt->execute(['id'=>$id]);
            $this->conn->commit();
        } catch(PDOException $ex) {
            // If something went wrong rollback!
            $this->conn->rollBack();
            echo $ex->getMessage();
        } 
    }
}