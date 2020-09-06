<?php
declare(strict_types=1);

namespace Iamvar\Rates\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sources")
 */
class Source
{
    /**
     * @ORM\Id
     * @ORM\Column(name="name", type="string")
     */
    private string $name;
    /**
     * @ORM\Column(name="description", type="string")
     */
    private string $description;
    /**
     * @ORM\Column(name="default_weight", type="integer")
     */
    private int $defaultWeight;

    public function getDefaultWeight(): int
    {
        return $this->defaultWeight;
    }

    public function setDefaultWeight(int $defaultWeight): self
    {
        $this->defaultWeight = $defaultWeight;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}