<?php

namespace App\Helpers;

class PageHelper 
{
    public function getPage($routeName = '') : string
    {
        switch ($routeName) {
            case '':
                return 'dashboard';
            case 'category.index':
                return 'Categories';
            case 'stock.index':
                return 'Stocks';
            case 'product.index':
                return 'Products';
            case 'inventory.index':
                return 'Inventory';
            
            default:
                return 'dashboard';
        }
    }
}
