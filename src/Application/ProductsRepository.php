<?php


namespace Athlan\SymplexPrestahop\Application;


interface ProductsRepository
{
    function updateProduct(string $eanCode, ProductDiff $product);
}
