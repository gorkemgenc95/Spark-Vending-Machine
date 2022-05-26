<?php

namespace Zoosk\VendingMachine;

class PaymentManager
{
	private int $balance;
	private int $price;
	private int $change;

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
	 * @return int
	 */
	public function getChange(): int
	{
		return $this->change;
	}

	/**
	 * price getter function
	 *
	 * @return int
	 */
	public function getPrice(): int
	{
		return $this->price;
	}

	/**
	 * balance getter function
	 *
	 * @return int
	 */
	public function getBalance(): int
	{
		return $this->balance;
	}

	/**
	 * Adds given sum into the current balance
	 *
	 * @param int $sum value to be added to total balance
	 * @return void
	 */
	public function addBalance(int $sum)
	{
		if ($sum > 0) {
			$this->balance = $this->balance + $sum;
		}
	}

	/**
	 * Sets the price of the selected product for payment
	 *
	 * @param int $price price of the selected product
	 * @return void
	 */
	public function setPrice(int $price)
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