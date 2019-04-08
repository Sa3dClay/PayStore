<?php

class Product {
    private $id;
    private $name;
    private $type;
    private $brand;
    private $price;
    private $quantity;
    private $image_name;
    private $number_sold;
    
    public static $number_of_products = 0;
    
    function __construct($val) {
        if($val == NULL) {
            // Do No Thing
        } else {
            Product::$number_of_products++;
        }
    }//End Of Constructor
    
    function __set($name, $value) {
        switch($name) {
            case 'id' : $this->id = $value; break;
            case 'name' : $this->name = $value; break;
            case 'type' : $this->type = $value; break;
            case 'brand' : $this->brand = $value; break;
            case 'price' : $this->price = $value; break;
            case 'quantity' : $this->quantity = $value; break;
            case 'image_name' : $this->image_name = $value; break;
            case 'number_sold' : $this->number_sold = $value; break;
            default : 
                echo $name . ' Not Found';
        }
        #echo 'Set ' . $name . ' To ' . $value . '<br />';
    }//end of function set
    
    function __get($name) {
        #echo 'Asked for ' . $name . '<br />';
        return $this->$name;
    }
    
    function __toString() {
        return "Product Name: " . $this->name . "<br />Product Id: " . $this->id . ",<br />Product Type: " . $this->type . 
                "<br />Product Brand: " . $this->brand . "<br />Product Price: " . $this->price . 
                "<br />Product Quantity" . $this->quantity . "<br />Number Of Sold Item: " . $this->number_sold;
    }
    
    public function check_quantity() {
        if($this->quantity > 0) {
            return True;
        } else {
            return False;
        }
    }
    
    public function connect() {
        include_once '../Models/DataBase.php';
        $file_name = '../Models/credential.php';
        $db = DataBase::getInstance($file_name);
        
        return $db;
    }
    
    public function get_products() {
        $db = $this->connect();
        $query = "SELECT id, name, type, brand, price, quantity, image_name FROM product";
        $products = $db->fetch_query($query);
        return $products;
    }
    
    public function get_product_by_id($pro_id) {
        $db = $this->connect();
        
        $query = "SELECT * FROM product WHERE id = $pro_id";
        $product = $db->fetch_query($query);
        return $product;
    }
    
    public function dec_quantity($pro_id, $nPro) {
        $db = $this->connect();
        $conn = $db->get_connection();
        
        $query = "SELECT Quantity FROM product WHERE Id = $pro_id";
        $arrqun = $db->fetch_query($query);
        $qun = $arrqun[0]['Quantity'];
        
        $newqun = $qun - $nPro;
        
        $query2 = "UPDATE product SET Quantity = $newqun WHERE Id = $pro_id";
        $res = $conn->query($query2);
        return $res;
    }
    
    public function inc_quantity($pro_id, $nPro) {
        $db = $this->connect();
        $conn = $db->get_connection();
        
        $query = "SELECT Quantity FROM product WHERE Id = $pro_id";
        $arrqun = $db->fetch_query($query);
        $qun = $arrqun[0]['Quantity'];
        
        $newqun = $qun + $nPro;
        
        $query2 = "UPDATE product SET Quantity = $newqun WHERE Id = $pro_id";
        $res = $conn->query($query2);
        return $res;
    }
    
    public function get_most_paid() {
        $db = $this->connect();
        
        $sql = "SELECT * FROM product INNER JOIN sold_products ON product.id = sold_products.pro_id ORDER BY sold_products.pro_qn DESC";
        $arr = $db->fetch_query($sql);
        return $arr;
    }
    
}//End Of Class Product

/*
$pro = new Product(NULL);
$arr = $pro->get_most_paid();
print_r($arr);
*/