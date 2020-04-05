<?php

namespace App\Services;

use App\Entity\Numbers;

class NumbersFactory
{
    /**
     * @var Numbers
     */
    private $numbers;

    public function createNewNumbers()
    {
        $numbers = new Numbers();
        $numbers->setCreatedAt(new \DateTime());
        $this->numbers = $numbers;
        return $numbers;
    }

    public function setUpResults()
    {
        $this->numbers->setResult($this->getMax());
    }

    private function getMax()
    {
        $indexArray = $this->getResultsArray();

        return max($indexArray);
    }

    private function getResultsArray()
    {
        $indexArray = array_fill(0, $inputNumber = $this->numbers->getInputNumber() + 1, null);
        foreach ($indexArray as $index => $value) {
            switch ($index) {
                case 0:
                    $indexArray[$index] = 0;
                    break;
                case 1:
                    $indexArray[$index] = 1;
                    break;
                case $index % 2 === 0:
                    $indexArray[$index] = $indexArray[$index / 2];
                    break;
                case $index % 2 !== 0:
                    $i = ($index - 1) / 2;
                    $indexArray[$index] = $indexArray[$i] + $indexArray[$i + 1];
            }
        }

        return $indexArray;
    }


}