<?php
//items.php
$items [] = new Item("Taco","Mystery meat taco with mighty spicy salsa! - $4.95", 4.95);
$items [] = new Item("Burrito","Bean Burrito! - $3.95", 3.95);
$items [] = new Item("Enchilada","Extraordinary enchilada! - 5.95", 5.95);
$extras[] = new Extra("Sour Cream", .25);
$extras[] = new Extra("Cheese", .25);
$extras[] = new Extra("Guacamole", .25);
class Item
{
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Quantity = 0;
    const TAX = 0.095;
    
    public function __construct($Name,$Description,$Price)
    {
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        
    }#end Item constructor
}#end Item class
class Extra
{
    public $ExtraName = '';
    public $ExtraPrice = 0;
    public $ExtraQuantity = 0;
    public function __construct($ExtraName,$ExtraPrice)
    {
        $this->ExtraName = $ExtraName;
        $this->ExtraPrice = $ExtraPrice;
        
    }#end Item constructor
}#end Item class