<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation as Api;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter as ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(
 *     name="tasks",
 *     options={
 *         "comment"="ToDo Tasks"
 *     },
 *     indexes={
 *         @ORM\Index(name="idx_tasks_completion_date", columns={"completion_date"})
 *     }
 * )
 * @ORM\Entity
 */
#[Api\ApiResource(
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']],
)]
#[Api\ApiFilter(ApiFilter\DateFilter::class, properties: ['completionDate'])]
#[Api\ApiFilter(ApiFilter\NumericFilter::class, properties: ['priority'])]
#[Api\ApiFilter(ApiFilter\BooleanFilter::class, properties: ['completed'])]
#[Api\ApiFilter(ApiFilter\OrderFilter::class, properties: [
    'name', 'completionDate', 'priority' => ['nulls_comparison' => ApiFilter\OrderFilter::NULLS_SMALLEST], 'createdAt'
])]
class Task
{
    use Traits\CreatedAtTrait;
    use Traits\UpdatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    #[Serializer\Groups(['read'])]
    private string $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Serializer\Groups(['read', 'write'])]
    private string $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    #[Serializer\Groups(['read', 'write'])]
    private ?string $description = null;

    /**
     * @ORM\Column(name="completion_date", type="datetime", nullable=true)
     */
    #[Serializer\Groups(['read', 'write'])]
    private ?\DateTimeInterface $completionDate = null;

    /**
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    #[Assert\Range(min: 1, max: 5)]
    #[Serializer\Groups(['read', 'write'])]
    private ?int $priority = null;

    /**
     * @ORM\Column(name="completed", type="boolean", options={"default": false})
     */
    #[Serializer\Groups(['read', 'write'])]
    private bool $completed = false;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Task
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Task
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Task
    {
        $this->description = $description;
        return $this;
    }

    public function getCompletionDate(): ?\DateTimeInterface
    {
        return $this->completionDate;
    }

    public function setCompletionDate(?\DateTimeInterface $completionDate): Task
    {
        $this->completionDate = $completionDate;
        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): Task
    {
        $this->priority = $priority;
        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): Task
    {
        $this->completed = $completed;
        return $this;
    }
}
