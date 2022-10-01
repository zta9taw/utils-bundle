<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Entity;

use DateTimeInterface;

interface TimestampEntityInterface
{
    public function getCreatedAt(): DateTimeInterface;

    public function getUpdatedAt(): ?DateTimeInterface;

    public function setCreatedAt(DateTimeInterface $createdAt): static;

    public function setUpdatedAt(?DateTimeInterface $updatedAt): static;
}
