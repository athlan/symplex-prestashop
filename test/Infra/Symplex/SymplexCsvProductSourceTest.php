<?php declare(strict_types=1);

namespace Athlan\SymplexPrestahop\Test\Infra\Symplex;

use Athlan\SymplexPrestahop\Application\ProductsSource;
use Athlan\SymplexPrestahop\Infra\Symplex\SymplexCsvProductSource;
use PHPUnit\Framework\TestCase;

class SymplexCsvProductSourceTest extends TestCase
{
    public function test_extracts_products_from_file()
    {
        // given
        $productsStore = $this->givenProductStore('baza.csv');

        // when
        $products = $productsStore->productList();

        // then
        $this->assertGreaterThan(0, count($products),
            'Loads products');
    }

    protected function givenProductStore(string $filePath): ProductsSource
    {
        return new SymplexCsvProductSource($filePath);
    }
}
