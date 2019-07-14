<?php


namespace Athlan\SymplexPrestahop\Infra\Prestashop;


use Athlan\SymplexPrestahop\Application\Product;
use Athlan\SymplexPrestahop\Application\ProductsSource;
use Doctrine\DBAL\Connection;
use Iterator;

class PrestashopProductSource implements ProductsSource
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var PrestashopConfiguration
     */
    private $prestashopConfiguration;

    /**
     * PrestashopProductSource constructor.
     * @param Connection $connection
     * @param PrestashopConfiguration $prestashopConfiguration
     */
    public function __construct(Connection $connection, PrestashopConfiguration $prestashopConfiguration)
    {
        $this->connection = $connection;
        $this->prestashopConfiguration = $prestashopConfiguration;
    }

    /**
     * @return Iterator of Product
     */
    function productList(): Iterator
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->addSelect('p.reference AS reference')
            ->addSelect('p.price AS price')
            ->addSelect('pl.name AS name')
            ->addSelect('sav.quantity AS quantity')
            ->from($this->table('product'), 'p')
            ->leftJoin($this->table('product_lang'), 'pl.id_product = p.id_product AND pl.id_lang = 1 AND pl.id_shop = 1', 'pl')
            ->leftJoin($this->table('stock_available'), 'sav.id_product = p.id_product AND sav.id_product_attribute = 0 AND sav.id_shop = 1 AND sav.id_shop_group = 0', 'sav');

        return $this->connection->project($qb, $qb->getParameters(), function ($row) {
            return new Product(
                $row['reference'],
                $row['name'],
                (float) $row['price'],
                (float) $row['quantity']
            );
        });
    }

    private function table(string $string)
    {
        return $this->prestashopConfiguration->tablePrefix . $string;
    }
}
