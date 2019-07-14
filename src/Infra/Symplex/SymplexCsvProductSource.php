<?php declare(strict_types=1);

namespace Athlan\SymplexPrestahop\Infra\Symplex;

use Athlan\SymplexPrestahop\Application\Product;
use Athlan\SymplexPrestahop\Application\ProductsSource;

class SymplexCsvProductSource implements ProductsSource
{
    /**
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return Product[]
     */
    function productList(): array
    {
        // TODO: Implement productList() method.
        return [];
    }
}
