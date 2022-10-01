<?php

declare(strict_types=1);

namespace Zta9taw\Bundle\UtilsBundle\Utils\Traits;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Security\Core\User\UserInterface;

trait BlameableEntityTrait
{
    #[ManyToOne(targetEntity: UserInterface::class)]
    #[JoinColumn(name: 'created_by_id', referencedColumnName: 'id', nullable: false)]
    protected ?UserInterface $createdBy = null;

    #[ManyToOne(targetEntity: UserInterface::class)]
    #[JoinColumn(name: 'updated_by_id', referencedColumnName: 'id')]
    protected ?UserInterface $updatedBy = null;

    function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(UserInterface $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?UserInterface
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?UserInterface $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}
