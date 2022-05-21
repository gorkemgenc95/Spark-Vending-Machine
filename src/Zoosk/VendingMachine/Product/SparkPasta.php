<?php

namespace Zoosk\VendingMachine\Product;

class SparkPasta extends Product
{
	public function getName(): string
	{
		return "spark-pasta";
	}

	public function getDescription(): array
	{
		return [
			"Portion Amount" => "100 g",
			"Calories (kcal)" => "131",
			"Total fat" => "1.1 g",
			"Saturated Fat" => "0.2 g",
			"Cholesterol" => "33 mg",
			"Sodium" => "6 mg",
			"Potassium" => "24 mg",
			"Carbs" => "25 g",
			"Protein" => "5 g",
		];
	}
}