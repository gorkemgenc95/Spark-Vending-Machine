<?php

namespace Zoosk\VendingMachine;

class PaymentManager
{
	private float $balance;
	private float $price;
	private float $change;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->balance = 0;
		$this->price = 0;
		$this->change = 0;
	}

	/**
	 * change getter function
	 *
	 * @return float
	 */
	public function getChange(): float
	{
		return $this->change;
	}

	/**
	 * price getter function
	 *
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}

	/**
	 * balance getter function
	 *
	 * @return float
	 */
	public function getBalance(): float
	{
		return $this->balance;
	}

	/**
	 * Adds given sum into the current balance
	 *
	 * @param float $sum value to be added to total balance
	 * @return void
	 */
	public function addBalance(float $sum)
	{
		if ($sum > 0) {
			$this->balance = $this->balance + $sum;
		}
	}

	/**
	 * Sets the price of the selected product for payment
	 *
	 * @param float $price price of the selected product
	 * @return void
	 */
	public function setPrice(float $price)
	{
		$this->price = $price;
	}

	/**
	 * Returns the change to the consumer
	 *
	 * @return void
	 */
	public function giveChange()
	{
		$this->change = $this->balance;
		$this->balance = 0;
	}

	/**
	 * Subtracts the price from the balance
	 *
	 * @return void
	 */
	public function purchaseProduct()
	{
		$this->balance = $this->balance - $this->price;
	}

	/**
	 * Checks if the balance is enough to buy the selected product
	 *
	 * @return bool
	 */
	public function isBalanceSufficient(): bool
	{
		return $this->balance >= $this->price;
	}
}