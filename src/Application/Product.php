<?php


namespace Athlan\SymplexPrestahop\Application;


class Product
{
    /**
     * @var string
     */
    private $eanCode;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $qty;

    public function __construct(string $eanCode, string $name, float $price, float $qty)
    {
        $this->eanCode = $eanCode;
        $this->name = $name;
        $this->price = $price;
        $this->qty = $qty;
    }

    public function getEanCode(): string
    {
        return $this->eanCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQty(): float
    {
        return $this->qty;
    }

    /**
     * @param Product[] $products
     * @return Product[]
     */
    public static function mapByEan(array $products): array
    {
        return array_combine(
            array_map(function (Product $product) {
                return $product->getEanCode();
            }, $products),
            $products
        );
    }
}
