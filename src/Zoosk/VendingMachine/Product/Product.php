<?php

namespace Zoosk\VendingMachine\Product;

abstract class Product
{
	protected int $count;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->setCount(0);
	}

	/**
	 * Product name getter function
	 *
	 * @return string
	 */
	public abstract function getName(): string;

	/**
	 * Product description getter function
	 *
	 * @return array
	 */
	public abstract function getDescription(): array;

	/**
	 * Product price getter function
	 *
	 * @return float
	 */
	public function getPrice(): float
	{
		return 0;
	}

	/**
	 * Product count getter function
	 *
	 * @return int
	 */
	public function getCount(): int
	{
		return $this->count;
	}

	/**
	 * Returns the details of the product
	 *
	 * @return array
	 */
	public function getInfo(): array
	{
		return [
			"name" => $this->getName(),
			"description" => $this->getDescription(),
			"price" => $this->getPrice(),
			"count" => $this->getCount()
		];
	}

	/**
	 * Product count setter function
	 *
	 * @param int $count value to be set as new count
	 * @return void
	 */
	public function setCount(int $count)
	{
		$this->count = $count;
	}

	/**
	 * Increases the product count by one
	 *
	 * @return void
	 */
	public function addOne(): void
	{
		$this->setCount( $this->getCount() + 1 );
	}

	/**
	 * Decreases the product count by one
	 *
	 * @return void
	 */
	public function removeOne(): void
	{
		$this->setCount( $this->getCount() - 1 );
	}

	/**
	 * Checks if the product has run out of stock
	 *
	 * @return bool
	 */
	public function isOutOfStock(): bool
	{
		return $this->getCount() === 0;
	}
}