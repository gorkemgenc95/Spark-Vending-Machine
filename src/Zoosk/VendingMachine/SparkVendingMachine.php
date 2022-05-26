<?php

namespace Zoosk\VendingMachine;

class SparkVendingMachine
{
	private InventoryManager $inventoryManager;
	private PaymentManager $paymentManager;
	private string $selectedSKU;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->inventoryManager = new InventoryManager();
		$this->paymentManager = new PaymentManager();
		$this->selectedSKU = "";
	}

	/**
	 * paymentManager getter function
	 *
	 * @return PaymentManager
	 */
	public function getPaymentManager(): PaymentManager
	{
		return $this->paymentManager;
	}

	/**
	 * inventoryManager getter function
	 *
	 * @return InventoryManager
	 */
	public function getInventoryManager(): InventoryManager
	{
		return $this->inventoryManager;
	}

	/**
	 * selectedSKU getter function
	 *
	 * @return string
	 */
	public function getSelectedSKU(): string
	{
		return $this->selectedSKU;
	}

	/**
	 * Adds a given list of products to the inventory
	 *
	 * @param string[] $skus List of products represented by their SKUs
	 * @return void
	 */
	public function addProducts(array $skus): void
	{
		foreach ($skus as $sku) {
			$this->inventoryManager->addProduct($sku);
		}
	}

	/**
	 * Lets the user select a product
	 *
	 * @param string $sku Identifier of product type
	 * @return void
	 */
	public function selectProduct(string $sku): void
	{
		$price = $this->inventoryManager->selectProduct($sku);
		switch ($price) {
			case -1:
				$this->cancelSelection();
				break;
			default:
				$this->selectedSKU = $sku;
				$this->paymentManager->setPrice($price);
				break;
		}
	}

	/**
	 * Cancels the current product selection
	 *
	 * @return void
	 */
	public function cancelSelection(): void
	{
		$this->selectedSKU = "";
		$this->paymentManager->setPrice(0);
	}

	/**
	 * Adds the inserted coins to the balance
	 *
	 * @param int $sparkCoin
	 * @return void
	 */
	public function insertCoin(int $sparkCoin)
	{
		$this->paymentManager->addBalance($sparkCoin);
	}

	/**
	 * Lets the user purchase the product
	 * Final step of the process
	 *
	 * @return bool
	 */
	public function purchaseProduct(): bool
	{

		if (empty($this->selectedSKU)) {
			return false;
		}
		if ($this->paymentManager->isBalanceSufficient()) {
			$this->paymentManager->purchaseProduct();
			$this->paymentManager->giveChange();
			$this->inventoryManager->removeProduct($this->selectedSKU);
			$this->cancelSelection();
			return true;
		}
		return false;
	}

	/**
	 * Return all products currently in the dispenser
	 *
	 * @return string[] List of products
	 */
	public function listProducts(): array
	{
		return $this->inventoryManager->listProducts();
	}

	public function dispensedProducts(): array
	{
		return $this->inventoryManager->getDispensedProducts();
	}
}
