<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/timestampable.md
 */
trait UpdatedAtTrait
{
    /**
     * @ORM\Column(
     *     name="updated_at",
     *     type="datetime",
     *     options={
     *         "default"="CURRENT_TIMESTAMP",
     *         "comment"="Date of last change"
     *     }
     * )
     * @Gedmo\Timestampable(on="update")
     */
    #[Serializer\Groups(['read'])]
    protected ?\DateTimeInterface $updatedAt;

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt === null ? new \DateTime() : $updatedAt;
        return $this;
    }
}
