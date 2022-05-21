<?php

namespace Zoosk\Test\VendingMachine;

use PHPUnit\Framework\TestCase;
use Zoosk\VendingMachine\SparkVendingMachine;

class SparkVendingMachineTest extends TestCase
{
	const SKU_SPARKLING_WATER = "sparkling-water";
	const SKU_SPARK_PASTA = "spark-pasta";
	const SKU_SPARK_SODA = "spark-soda";

	protected SparkVendingMachine $vendingMachine;

	protected function setUp(): void
	{
		$this->vendingMachine = new SparkVendingMachine();
	}

	public function testDispensesProductSelectCheck()
	{
		// add products
		$this->vendingMachine->addProducts([self::SKU_SPARKLING_WATER, self::SKU_SPARK_PASTA]);

		// select a non-existent product
		$this->vendingMachine->selectProduct("spark-donut");
		$this->assertEmpty($this->vendingMachine->getSelectedSKU());

		// select a product out of stock
		$this->vendingMachine->selectProduct(self::SKU_SPARK_SODA);
		$this->assertEmpty($this->vendingMachine->getSelectedSKU());

		// select a product in stock
		$this->vendingMachine->selectProduct(self::SKU_SPARK_PASTA);
		$this->assertEquals(self::SKU_SPARK_PASTA, $this->vendingMachine->getSelectedSKU());

		// cancel selection
		$this->vendingMachine->cancelSelection();
		$this->assertEmpty($this->vendingMachine->getSelectedSKU());

		// add an out-of-stock product then select it
		$this->vendingMachine->addProducts([self::SKU_SPARK_SODA, self::SKU_SPARK_SODA, self::SKU_SPARK_SODA]);
		$this->vendingMachine->selectProduct(self::SKU_SPARK_SODA);
		$this->assertEquals(self::SKU_SPARK_SODA, $this->vendingMachine->getSelectedSKU());
	}

	public function testDispensesProductCountCheck()
	{
		// add products
		$this->vendingMachine->addProducts([self::SKU_SPARKLING_WATER, self::SKU_SPARKLING_WATER, self::SKU_SPARK_PASTA, self::SKU_SPARKLING_WATER]);

		// check product count
		$products = $this->vendingMachine->dispensedProducts();
		$this->assertEquals(3, $products[self::SKU_SPARKLING_WATER]['count']);

		// remove one and check product count
		$this->vendingMachine->getInventoryManager()->removeProduct(self::SKU_SPARKLING_WATER);
		$products = $this->vendingMachine->dispensedProducts();
		$this->assertEquals(2, $products[self::SKU_SPARKLING_WATER]['count']);

		// set and check product count
		$this->vendingMachine->getInventoryManager()->setProductCount(self::SKU_SPARKLING_WATER, 10);
		$products = $this->vendingMachine->dispensedProducts();
		$this->assertEquals(10, $products[self::SKU_SPARKLING_WATER]['count']);
	}

	public function testPurchaseProduct()
	{
		// add products
		$this->vendingMachine->addProducts([self::SKU_SPARKLING_WATER, self::SKU_SPARK_PASTA]);

		// dispense in-stock product
		$this->vendingMachine->selectProduct(self::SKU_SPARK_PASTA);
		$this->assertTrue($this->vendingMachine->purchaseProduct());

		// dispense out-of-stock product
		$this->vendingMachine->selectProduct(self::SKU_SPARK_SODA);
		$this->assertFalse($this->vendingMachine->purchaseProduct());
	}

	public function testPurchaseBalanceAndChangeCheck()
	{
		// add products
		$this->vendingMachine->addProducts([self::SKU_SPARKLING_WATER, self::SKU_SPARK_PASTA]);
		$money = 5.25;

		// select product
		$this->vendingMachine->selectProduct(self::SKU_SPARK_PASTA);

		// add sum to balance and check balance
		$this->vendingMachine->addBalance($money);
		$this->assertEquals($money, $this->vendingMachine->getPaymentManager()->getBalance());

		// dispense
		$this->vendingMachine->purchaseProduct();

		// check balance and change after purchase
		$this->assertEquals(0, $this->vendingMachine->getPaymentManager()->getBalance());
		$this->assertEquals($money, $this->vendingMachine->getPaymentManager()->getChange());
	}

	public function testDispensesProductCountCheckAfterDispense()
	{
		// add products
		$this->vendingMachine->addProducts([self::SKU_SPARKLING_WATER, self::SKU_SPARKLING_WATER, self::SKU_SPARK_PASTA, self::SKU_SPARK_SODA]);

		// dispense
		$this->vendingMachine->selectProduct(self::SKU_SPARKLING_WATER);
		$this->assertTrue($this->vendingMachine->purchaseProduct());

		// dispense
		$this->vendingMachine->selectProduct(self::SKU_SPARK_PASTA);
		$this->assertTrue($this->vendingMachine->purchaseProduct());

		// dispense out-of-stock
		$this->vendingMachine->selectProduct(self::SKU_SPARK_PASTA);
		$this->assertFalse($this->vendingMachine->purchaseProduct());

		// dispense in-stock again
		$this->vendingMachine->addProducts([self::SKU_SPARK_PASTA]);
		$this->vendingMachine->selectProduct(self::SKU_SPARK_PASTA);
		$this->assertTrue($this->vendingMachine->purchaseProduct());

		// get dispensed products and check their counts
		$products = $this->vendingMachine->dispensedProducts();
		$expected = $this->prepareProductCountList(1, 0, 1);
		$actual = $this->prepareProductCountList($products[self::SKU_SPARKLING_WATER]['count'], $products[self::SKU_SPARK_PASTA]['count'], $products[self::SKU_SPARK_SODA]['count']);

		$this->assertEquals($expected, $actual);
	}

	public function testPaymentBalanceCheckWithNegativeSum()
	{
		$money = -4.75;
		$balance = $this->vendingMachine->getPaymentManager()->getBalance();
		$this->vendingMachine->addBalance($money);
		$this->assertEquals($balance, $this->vendingMachine->getPaymentManager()->getBalance());
	}

	private function prepareProductCountList($countSparklingWater, $countSparkPasta, $countSparkSoda): array
	{
		return [
			self::SKU_SPARKLING_WATER => $countSparklingWater,
			self::SKU_SPARK_PASTA => $countSparkPasta,
			self::SKU_SPARK_SODA => $countSparkSoda
		];
	}

}
