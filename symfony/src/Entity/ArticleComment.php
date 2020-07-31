<?php

namespace App\Entity;

use App\Repository\ArticleCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleCommentRepository::class)
 */
class ArticleComment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comment", fetch="LAZY")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=ArticleComment::class, inversedBy="recomment")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=ArticleComment::class, mappedBy="parent", fetch="LAZY")
     */
    private $recomment;


    public function __construct()
    {
        $this->recomment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRecomment(): Collection
    {
        return $this->recomment;
    }

    public function addRecomment(self $recomment): self
    {
        if (!$this->recomment->contains($recomment)) {
            $this->recomment[] = $recomment;
            $recomment->setParent($this);
        }

        return $this;
    }

    public function removeRecomment(self $recomment): self
    {
        if ($this->recomment->contains($recomment)) {
            $this->recomment->removeElement($recomment);
            // set the owning side to null (unless already changed)
            if ($recomment->getParent() === $this) {
                $recomment->setParent(null);
            }
        }

        return $this;
    }
}
