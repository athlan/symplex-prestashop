<?php declare(strict_types=1);

namespace Athlan\SymplexPrestahop\Infra\Symplex;

use Iterator;
use Athlan\SymplexPrestahop\Application\Product;
use Athlan\SymplexPrestahop\Application\ProductsSource;
use League\Csv\CharsetConverter;
use League\Csv\Reader;

class SymplexCsvProductSource implements ProductsSource
{
    const ENCODING_DEFAULT = 'iso-8859-2';

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var string
     */
    private $encoding;

    public function __construct(string $filePath,
                                string $encoding = self::ENCODING_DEFAULT)
    {
        $this->filePath = $filePath;
        $this->encoding = $encoding;
    }

    /**
     * @return Iterator of Product
     */
    function productList(): Iterator
    {
        $csv = Reader::createFromPath($this->filePath, 'r');
        $csv->setDelimiter("\t");
        $csv->setHeaderOffset(0);

        $encoder = (new CharsetConverter())->inputEncoding($this->encoding);
        $csv = $encoder->convert($csv);

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
            (float) $record['v_products_quantity']
        );
    }
}
