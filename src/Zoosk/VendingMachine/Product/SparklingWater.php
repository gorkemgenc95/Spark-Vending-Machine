<?php

namespace Zoosk\VendingMachine\Product;

class SparklingWater extends Product
{
	public function getName(): string
	{
		return "sparkling-water";
	}

	public function getDescription(): array
	{
		return [
			"Portion Amount" => "100 g",
			"Calories (kcal)" => "0",
			"Total fat" => "0 g",
			"Saturated Fat" => "0 g",
			"Cholesterol" => "0 mg",
			"Sodium" => "21 mg",
			"Potassium" => "2 mg",
			"Carbs" => "0 g",
			"Protein" => "0 g",
		];
	}
}