<?php declare(strict_types=1);

namespace Athlan\SymplexPrestahop\Test\Infra\Symplex;

use Athlan\SymplexPrestahop\Application\Product;
use Athlan\SymplexPrestahop\Application\ProductsSource;
use Athlan\SymplexPrestahop\Infra\Symplex\SymplexCsvProductSource;
use PHPUnit\Framework\TestCase;

class SymplexCsvProductSourceTest extends TestCase
{
    public function test_extracts_products_from_file()
    {
        // given
        $productsStore = $this->givenProductStore(__DIR__ . '/baza.csv');

        // when
        $products = iterator_to_array($productsStore->productList());

        // then
        $this->assertGreaterThan(0, count($products),
            'Loads all products');

        $productByEan = Product::mapByEan($products);

        $product = $productByEan['57730004'];
        $this->assertEquals("ZIEMNIAKI MLODE", $product->getName(), 'Maps name');
        $this->assertEquals(4.99, $product->getPrice(), 'Maps price');
        $this->assertEquals(26.011, $product->getQty(), 'Maps qty');
    }

    public function test_converts_special_chars_properly()
    {
        // given
        $productsStore = $this->givenProductStore(__DIR__ . '/baza.csv');

        // when
        $products = iterator_to_array($productsStore->productList());

        // then
        $productByEan = Product::mapByEan($products);

        $product = $productByEan['5906734200820'];
        $this->assertEquals("REKLAMÓWKA ECO 100", $product->getName(), 'Maps name');
        $this->assertEquals(0.20, $product->getPrice(), 'Maps price');
        $this->assertEquals(-2629, $product->getQty(), 'Maps qty');
    }

    protected function givenProductStore(string $filePath): ProductsSource
    {
        return new SymplexCsvProductSource($filePath);
    }
}
