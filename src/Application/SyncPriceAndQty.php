<?php


namespace Athlan\SymplexPrestahop\Application;


use Athlan\SymplexPrestahop\Infra\Symplex\SymplexCsvProductSource;

class SyncPriceAndQty
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


    public function sync(string $filePath,
                         SyncPriceAndQtyResult $result)
    {
        $fileProductsSource = new SymplexCsvProductSource($filePath);
        $fileProducts = $fileProductsSource->productList();
        $shopProducts = $this->shopProductsSource->productList();
        $shopProducts = Product::mapByEan(iterator_to_array($shopProducts));

        /* @var $product Product */
        foreach ($fileProducts as $product) {
            $ean = $product->getEanCode();
            if (!array_key_exists($ean, $shopProducts)) {
                $result->productNotFoundInShop($product);
                continue;
            }

            $diff = $this->createDiff($product);
            $this->productsRepository->updateProduct($ean, $diff);
            $result->productSynchronized($product);
        }
    }

    private function createDiff(Product $product): ProductDiff
    {
        $diff = new ProductDiff();

        $diff->price = $product->getPrice();
        $diff->qty = $product->getQty();

        return $diff;
    }
}
