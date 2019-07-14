<?php


namespace Athlan\SymplexPrestahop\Application;

interface SyncPriceAndQtyResult
{
    function productSynchronized(Product $product);
    function productNotFoundInShop(Product $product);
}
