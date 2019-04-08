<?php

include_once './WhiteList.php';
include_once './ShoppingCart.php';

interface Strategy {

    public function add($user_id, $pro_id);

}

class Context {

    private $strategy;
 
    function __construct(Strategy $strategy) {
       $this->strategy = $strategy;
    }
 
    public function executeStrategy($user_id, $pro_id) {
       return $this->strategy->add($user_id, $pro_id);
    }

}

class addWhiteList implements Strategy{

    function add($user_id, $pro_id) {
        $wl = new WhiteList();
        return $wl->add_to_love($user_id, $pro_id);
    }

}

class addToCart implements Strategy{

    function add($user_id, $pro_id) {
        $cart = new ShoppingCart();
        return $cart->add_to_cart($user_id, $pro_id);
    }

}