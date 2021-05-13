<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/timestampable.md
 */
trait CreatedAtTrait
{
    /**
     * @ORM\Column(
     *     name="created_at",
     *     type="datetime",
     *     options={
     *         "default"="CURRENT_TIMESTAMP",
     *         "comment"="Date of creation"
     *     }
     * )
     * @Gedmo\Timestampable(on="create")
     */
    #[Serializer\Groups(['read'])]
    protected ?\DateTimeInterface $createdAt;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt === null ? new \DateTime() : $createdAt;
        return $this;
    }
}
