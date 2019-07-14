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
        $productsStore = $this->givenProductStore(__DIR__ . '/baza.csv');

        // when
        $products = iterator_to_array($productsStore->productList());

        // then
        $this->assertGreaterThan(0, count($products),
            'Loads all products');
    }

    protected function givenProductStore(string $filePath): ProductsSource
    {
        return new SymplexCsvProductSource($filePath);
    }
}
