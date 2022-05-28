<?php
declare(strict_types=1);

namespace Iamvar\Rates\Rate\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sources")
 */
class Source
{
    /**
     * @ORM\Id
     * @ORM\Column(name="name", type="string", length=50, options={"fixed":true})
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
