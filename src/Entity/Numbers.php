<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NumbersRepository")
 */
class Numbers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank
     * @Assert\Range(
     *     min = 1,
     *     max = 99999,
     * )
     */
    private $inputNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResult(): ?int
    {
        $indexArray = array_fill(0, $inputNumber = $this->inputNumber + 1, null);
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

        return max($indexArray);
    }

    public function getInputNumber(): ?int
    {
        return $this->inputNumber;
    }

    public function setInputNumber(?int $inputNumber): self
    {
        $this->inputNumber = $inputNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function __toString()
    {
        return $this->getCreatedAt()->format('Y-m-d H:i:s').', '.$this->getInputNumber().', '.$this->getResult();
    }

}
