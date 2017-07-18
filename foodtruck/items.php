<?php
//items4.php
$items [] = new Item("Taco","Our Tacos are awesome!", 4.95);
$items [] = new Item("Burrito","Our Burritos are awesome!", 3.95);
$items [] = new Item("Enchilada","Our Enchiladas are awesome!", 5.95);
$myExtra = new Extra("Sour Cream", .25);
$config->extras[] = $myExtra;
$myExtra = new Extra("Cheese", .25);
$config->extras[] = $myExtra;
$myExtra = new Extra("Guacamole", .25);
$config->extras[] = $myExtra;
class Item
{
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Quantity = 0;
    
    public function __construct($Name,$Description,$Price)
    {
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        
    }#end Item constructor
}#end Item class
class Extra
{
    public $Name = '';
    public $extraPrice = 0;
    public $Extras = array();
    
    public function __construct($Name,$extraPrice)
    {
        $this->Name = $Name;
        $this->Price = $extraPrice;
        
    }#end Item constructor
}#end Item class