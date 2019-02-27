<?php

namespace App\Domain\Phone\AddPhone;

use App\Domain\Entity\Maker;

class AddPhoneInput
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var string */
    protected $price;

    /** @var string */
    protected $stock;

    /** @var Maker */
    protected $maker;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getStock(): string
    {
        return $this->stock;
    }

    public function getMaker(): Maker
    {
        return $this->maker;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function setStock(string $stock): void
    {
        $this->stock = $stock;
    }

    public function setMaker(Maker $maker)
    {
        $this->maker = $maker;
    }
}