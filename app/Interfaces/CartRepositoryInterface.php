<?php

namespace App\Interfaces;

interface CartRepositoryInterface
{
    // every user has one cart and add product in table cart_item that refer to cart table
    public function store_cart($user);
    //this function add item and quantity in cart_item table
    public function store_cart_item($user_id,$cart,$products);
}
