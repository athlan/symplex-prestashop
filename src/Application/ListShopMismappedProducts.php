<?php


namespace Athlan\SymplexPrestahop\Application;


use Athlan\SymplexPrestahop\Infra\Symplex\SymplexCsvProductSource;

class ListShopMismappedProducts
{
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * @var ProductsSource
     */
    private $shopProductsSource;

    /**
     * SyncPriceAndQty constructor.
     * @param ProductsRepository $productsRepository
     * @param ProductsSource $shopProductsSource
     */
    public function __construct(ProductsRepository $productsRepository,
                                ProductsSource $shopProductsSource)
    {
        $this->productsRepository = $productsRepository;
        $this->shopProductsSource = $shopProductsSource;
    }


    public function getList(string $filePath,
                         ListShopMismappedProductsResults $result)
    {
        $fileProductsSource = new SymplexCsvProductSource($filePath);
        $fileProducts = $fileProductsSource->productList();
        $fileProducts = Product::mapByEan(iterator_to_array($fileProducts));

        $shopProducts = $this->shopProductsSource->productList();

        /* @var $product Product */
        foreach ($shopProducts as $product) {
            $ean = $product->getEanCode();
            if (!array_key_exists($ean, $fileProducts)) {
                $result->productMismapped($product);
                continue;
            }
        }
    }
}
