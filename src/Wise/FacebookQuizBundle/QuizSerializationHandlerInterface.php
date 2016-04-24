<?php

namespace Wise\FacebookQuizBundle;

interface QuizSerializationHandlerInterface
{
	public function unserialize($question, $resolvedQuestion);
}