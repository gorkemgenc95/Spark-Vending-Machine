<?php

namespace Zoosk\VendingMachine\Product;

class SparkPizza extends Product
{
	public function getName(): string
	{
		return "spark-pizza";
	}

	public function getDescription(): array
	{
		return [
			"Portion Amount" => "100 g",
			"Calories (kcal)" => "266",
			"Total fat" => "10 g",
			"Saturated Fat" => "4.5 g",
			"Cholesterol" => "17 mg",
			"Sodium" => "598 mg",
			"Potassium" => "172 mg",
			"Carbs" => "33 g",
			"Protein" => "11 g",
		];
	}
}