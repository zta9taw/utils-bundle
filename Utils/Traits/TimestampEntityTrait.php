<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Utils\Traits;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait TimestampEntityTrait
{

    #[ORM\Column(type: 'datetimetz')]
    protected DateTimeInterface $createdAt;


    #[ORM\Column(type: 'datetimetz', nullable: true)]
    protected ?DateTimeInterface $updatedAt = null;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
