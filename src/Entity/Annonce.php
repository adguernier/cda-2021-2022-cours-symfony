<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @UniqueEntity("slug")
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 *      normalizationContext={"groups"={"read_annonce"}},
 *      denormalizationContext={"groups"={"write_annonce"}}
 * )
 */
class Annonce
{
    public const STATUS_VERY_BAD    = 0;
    public const STATUS_BAD         = 1;
    public const STATUS_GOOD        = 2;
    public const STATUS_VERY_GOOD   = 3;
    public const STATUS_PERFECT     = 4;

    public const STATUS = [
        self::STATUS_VERY_BAD,
        self::STATUS_BAD
    ];

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->slug = strtolower((new AsciiSlugger())->slug($this->title));
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
        $this->isSold = false;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->slug = strtolower((new AsciiSlugger())->slug($this->title));
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=4, max=255)
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(min=10, max=2000)
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("boolean")
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $isSold;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Assert\LessThan(5)
     * @Groups({"read_annonce", "write_annonce"})
     * @ApiProperty(
     *      attributes={
     *          "openapi_context"={
    *               "type"="string",
    *               "enum"=self::STATUS,
    *           }
     *      }
     * )
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read_annonce"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Groups({"read_annonce"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read_annonce"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="annonces", cascade={"persist"})
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="annonce", cascade={"persist"})
     * @Groups({"read_annonce", "write_annonce"})
     */
    private $address;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this; // fluent
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsSold(): ?bool
    {
        return $this->isSold;
    }

    public function setIsSold(bool $isSold): self
    {
        $this->isSold = $isSold;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
