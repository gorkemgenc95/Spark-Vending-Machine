<?php

namespace Zoosk\VendingMachine\Product;

class SparkSoda extends Product
{
	public function getName(): string
	{
		return "spark-soda";
	}

	public function getDescription(): array
	{
		return [
			"Portion Amount" => "100 g",
			"Calories (kcal)" => "41",
			"Total fat" => "0 g",
			"Saturated Fat" => "0 g",
			"Cholesterol" => "0 mg",
			"Sodium" => "4 mg",
			"Potassium" => "3 mg",
			"Carbs" => "11 g",
			"Protein" => "0 g",
		];
	}
}