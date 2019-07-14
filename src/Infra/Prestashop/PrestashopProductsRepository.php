<?php


namespace Athlan\SymplexPrestahop\Infra\Prestashop;


use Athlan\SymplexPrestahop\Application\ProductDiff;
use Athlan\SymplexPrestahop\Application\ProductsRepository;
use Doctrine\DBAL\Connection;

class PrestashopProductsRepository implements ProductsRepository
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
     * PrestashopProductsRepository constructor.
     * @param Connection $connection
     * @param PrestashopConfiguration $prestashopConfiguration
     */
    public function __construct(Connection $connection, PrestashopConfiguration $prestashopConfiguration)
    {
        $this->connection = $connection;
        $this->prestashopConfiguration = $prestashopConfiguration;
    }

    function updateProduct(string $eanCode, ProductDiff $product)
    {
        $qb = $this->connection->createQueryBuilder();

        $id = $this->connection->createQueryBuilder()
            ->select('p.id_product AS id')
            ->from($this->table('product'), 'p')
            ->where($qb->expr()->eq('p.reference', $qb->expr()->literal($eanCode)))
            ->execute()
            ->fetchColumn();

        $qb = $this->connection->createQueryBuilder();
        $q = $qb->update($this->table('product_shop'), 'p')
            ->set('p.price', ':price')
            ->setParameter(':price', $product->price)
            ->where($qb->expr()->eq('p.id_product', $id));
        $this->connection->executeUpdate($q, $q->getParameters());

        $qb = $this->connection->createQueryBuilder();
        $q = $qb->update($this->table('stock_available'), 'sav')
            ->set('sav.quantity', ':qty')
            ->setParameter(':qty', $product->qty)
            ->where($qb->expr()->eq('sav.id_product', $id));
        $this->connection->executeUpdate($q, $q->getParameters());
    }

    private function table(string $string)
    {
        return $this->prestashopConfiguration->tablePrefix . $string;
    }
}