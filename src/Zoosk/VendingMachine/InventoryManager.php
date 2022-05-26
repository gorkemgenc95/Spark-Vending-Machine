<?php

namespace Zoosk\VendingMachine;

use Zoosk\VendingMachine\Product\SparklingWater;
use Zoosk\VendingMachine\Product\SparkPasta;
use Zoosk\VendingMachine\Product\SparkSoda;
use Zoosk\VendingMachine\Product\SparkPizza;

class InventoryManager
{
	private array $products;
	private SparklingWater $sparklingWater;
	private SparkPasta $sparkPasta;
	private SparkSoda $sparkSoda;
	private SparkPizza $sparkPizza;
	private array $dispensedProducts = [];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->sparklingWater = new SparklingWater();
		$this->sparkPasta = new SparkPasta();
		$this->sparkSoda = new SparkSoda();
		$this->sparkPizza = new SparkPizza();
		$this->products = [
			$this->sparklingWater,
			$this->sparkPasta,
			$this->sparkSoda,
			$this->sparkPizza
		];
	}

	/**
	 * Finds the related object for the provided sku
	 *
	 * @param string $sku identifier of the product
	 * @return false|SparklingWater|SparkPizza|SparkSoda
	 */
	private function getProductByIdentifier(string $sku)
	{
		foreach ($this->products as $product) {
			if ($product->getName() === $sku) {
				return $product;
			}
		}
		return false;
	}

	/**
	 * Lists the details of the products
	 *
	 * @return array
	 */
	public function listProducts(): array
	{
		$products = [];
		foreach ($this->products as $product) {
			$products[$product->getName()] = $product->getInfo();
		}
		return $products;
	}

	/**
	 * Selects the related product object and returns its price
	 *
	 * @param string $sku identifier of the product
	 * @return float
	 */
	public function selectProduct(string $sku): float
	{
		$product = $this->getProductByIdentifier($sku);
		if ($product && !$product->isOutOfStock()) {
			return $product->getPrice();
		}
		return -1;
	}

	/**
	 * Increases the product count by one
	 *
	 * @param string $sku identifier of the product
	 * @return void
	 */
	public function addProduct(string $sku): void
	{
		$product = $this->getProductByIdentifier($sku);
		if ($product) {
			$product->addOne();
		}
	}

	/**
	 * Decreases the product count by one
	 *
	 * @param string $sku identifier of the product
	 * @return void
	 */
	public function removeProduct(string $sku): void
	{
		$product = $this->getProductByIdentifier($sku);
		if ($product) {
			$this->dispensedProducts[] = $sku;
			$product->removeOne();
		}
	}

	/**
	 * Directly sets the product count to enable bulk additions/deletions
	 *
	 * @param string $sku identifier of the product
	 * @param int $count new count of the product
	 * @return void
	 */
	public function setProductCount(string $sku, int $count): void
	{
		$product = $this->getProductByIdentifier($sku);
		if ($product) {
			$product->setCount($count);
		}
	}

	/**
	 * Return the list of all dispensed products so far
	 *
	 * @return array
	 */
	public function getDispensedProducts(): array
	{
		return $this->dispensedProducts;
	}
}