<?php


namespace Athlan\SymplexPrestahop\Application;

use Iterator;

interface ProductsSource
{
    /**
     * @return Iterator of Product
     */
    function productList(): Iterator;
}
