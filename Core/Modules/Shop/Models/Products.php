<?php
namespace Core\Modules\Shop\Models;
/**
 * Get methods for products.
 * @author <miloskajnaco@gmail.com>
 */
class Products
{
    /**
    * Class constructor.
    * @param object (\PDO)
    */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // default query string for selecting products and related items
    private $select_product = "SELECT * from products
        LEFT JOIN product_rating ON products.product_id = product_rating.product_id
        LEFT JOIN product_images ON products.product_id = product_images.product_id ";

    /**
     * Get details for selected product.
     * @param  int (id of product)
     * @return array
     */
    public function getProduct($product_id)
    {
        $stmt = $this->conn->prepare($this->select_product."
            LEFT JOIN product_manufacturers on products.manufacturer_id = product_manufacturers.manufacturer_id
            WHERE products.product_id = :product_id AND active = 1 LIMIT 1");
        $stmt->execute(['product_id' => $product_id]);
        $result = $stmt->fetch();
        // Add product reviews to result
        $result['reviews'] = $this->getReviews($product_id);
        return $result;
    }

    /**
     * Return list of reviews for product with selected id.
     * @param  int (id of product)
     * @return array
     */
    public function getReviews($product_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM product_reviews
                                      WHERE product_id = :product_id AND approved = 1 
                                      ORDER BY date_created DESC");
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get result variable of query for products filtered by passed parameters.
     * @param  int    $perpage     (number of products per page)
     * @param  int    $start       (starting product number)
     * @param  int    $category_id (category id)
     * @param  string $orderby     (order by attributes, default 'name')
     * @param  string $order       (default 'asc')
     * @param  string $param       (search parameter)
     * @param  bool   $desc_search (search param in description also)
     * @return array  
     */
    public function getProducts($perpage, $start, $category_id, $orderby = 'name', $order = 'asc',
                                $param = '', $desc_search = false)
    {
        // Make query
        $parents = $this->getParents($category_id);
        $subcat = '';
        foreach ($parents as $p) {// get all descendants categories to show
            if($subcat) {
                $subcat.= ' OR products.category_id = '.$p['category_id'];
             } else {
                $subcat = 'products.category_id = '.$p['category_id'];  
             }
        }
        if($param != '') {
            $param = "AND (name LIKE :param ";
            if($desc_search) {
                $param.= " OR description LIKE :param)";
            } else {
                $param.= " )";
            }   
        }
        $sql  = $this->select_product."WHERE ($subcat) $param
                                       AND active = 1 ORDER BY :ord $order
                                       LIMIT :start, :perpage";
        // Prepare query
        //echo $sql; die();
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ord', $orderby, \PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, \PDO::PARAM_INT);
        $stmt->bindParam(':perpage', $perpage, \PDO::PARAM_INT);
        if($param != '')
            $stmt->bindParam(':param', '%'.$param.'%', \PDO::PARAM_STR);
        // Execute query
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Count products.
     * @param  int    $category_id : category
     * @param  string $param       : search parameter, default ''
     * @param  string $paramtype   : column to search, default 'name'
     * @return int    : number of products
     */
    public function countProducts($category_id, $param = '', $desc_search = false)
    {         
        // Make query
        $parents = $this->getParents($category_id);
        $subcat = '';
        foreach ($parents as $p) {// get all descendants categories to show
            if($subcat) {
                $subcat.= ' OR products.category_id = '.$p['category_id'];
             } else {
                $subcat = 'products.category_id = '.$p['category_id'];  
             }
        }
        if($param != '') {
            $param = "AND (name LIKE :param ";
            if($desc_search) {
                $param.= " OR description LIKE :param)";
            } else {
                $param.= " )";
            }   
        }
        $stmt = $this->conn->prepare("SELECT COUNT(product_id) AS cnt
                                    FROM products
                                    WHERE ($subcat) $param AND active = 1");
        if($param != '')
            $stmt->bindParam(':param', '%'.$param.'%', \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Get all descendants of category from category tree.
     * @param  int   $category_id
     * @return array
     */
    public function getParents($category_id)
    {
        /*
        $parents = $this->db->query('SELECT category_id, parent FROM categories 
                                     ORDER BY parent ASC, category_id ASC')->fetchAll();
        $result = array($category_id);
        foreach ($parents as $p) {
            if (in_array($p['parent'], $result)) {
                $result[] = $p;
            }
        }
        return $result;
        */
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
     * Get top rated products.
     * @param int $num 
     * @return array
     */
    public function getTopRated($num)
    {
        $stmt = $this->conn->prepare("SELECT rating,products_rating.product_id,products.product_id,name,
                                price,active,path1 FROM products_rating
                                JOIN products ON products_rating.product_id=products.product_id
                                LEFT JOIN product_images ON products.product_id=product_images.product_id
                                WHERE active = 1
                                ORDER BY rating DESC
                                LIMIT");
        $stmt->bindParam($num, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get newest products.
     * @param type $num
     * @return array
     */
    public function get_newest($num)
    {
        $stmt = $this->conn->prepare($this->select_product."
                                WHERE active = 1
                                ORDER BY date_added DESC
                                LIMIT");
        $stmt->bindParam($num, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}