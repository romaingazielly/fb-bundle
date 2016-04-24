<?php

namespace Wise\FacebookQuizBundle\Loader;

class ConfigQuizLoader
{
	protected $questions;
	
	public function __construct(array $questions)
	{
		$this->questions = $questions;
	}

	public function load()
	{
		return $this->questions;
	}
}
