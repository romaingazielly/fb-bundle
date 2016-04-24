<?php

namespace Wise\FacebookQuizBundle;

class ResolvedQuestion
{
	protected $question;

	protected $answers;

    /**
     * Gets the value of question.
     *
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * Sets the value of question.
     *
     * @param mixed $question the question 
     *
     * @return self
     */
    protected function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Gets the value of answers.
     *
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }
    
    /**
     * Sets the value of answers.
     *
     * @param mixed $answers the answers 
     *
     * @return self
     */
    protected function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }
}
