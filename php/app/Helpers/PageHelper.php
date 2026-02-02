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
            
            default:
                return 'dashboard';
        }
    }
}
