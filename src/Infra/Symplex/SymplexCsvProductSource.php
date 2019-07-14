<?php declare(strict_types=1);

namespace Athlan\SymplexPrestahop\Infra\Symplex;

use Iterator;
use Athlan\SymplexPrestahop\Application\Product;
use Athlan\SymplexPrestahop\Application\ProductsSource;
use League\Csv\Reader;

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
     * @return Iterator of Product
     */
    function productList(): Iterator
    {
        $csv = Reader::createFromPath($this->filePath, 'r');
        $csv->setDelimiter("\t");
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            yield $this->mapRecord($record);
        }
    }

    private function mapRecord($record): Product
    {
        return new Product(
            $record['v_products_model'],
            $record['v_products_name_2'],
            (float) $record['v_products_price'],
            (int) $record['v_products_quantity']
        );
    }
}
