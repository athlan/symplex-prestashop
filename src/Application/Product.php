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
     * @var int
     */
    private $qty;

    public function __construct(string $eanCode, string $name, float $price, int $qty)
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

    public function getQty(): int
    {
        return $this->qty;
    }
}
