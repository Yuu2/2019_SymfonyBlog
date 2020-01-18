<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

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
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleTag", mappedBy="article", orphanRemoval=true)
     */
    private $article_tag;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleCategory", mappedBy="article", orphanRemoval=true)
     */
    private $article_category;

    public function __construct()
    {
        $this->article_tag = new ArrayCollection();
        $this->article_category = new ArrayCollection();
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

        return $this;
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

    /**
     * @return Collection|ArticleTag[]
     */
    public function getArticleTag(): Collection
    {
        return $this->article_tag;
    }

    public function addArticleTag(ArticleTag $articleTag): self
    {
        if (!$this->article_tag->contains($articleTag)) {
            $this->article_tag[] = $articleTag;
            $articleTag->setArticle($this);
        }

        return $this;
    }

    public function removeArticleTag(ArticleTag $articleTag): self
    {
        if ($this->article_tag->contains($articleTag)) {
            $this->article_tag->removeElement($articleTag);
            // set the owning side to null (unless already changed)
            if ($articleTag->getArticle() === $this) {
                $articleTag->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArticleCategory[]
     */
    public function getArticleCategory(): Collection
    {
        return $this->article_category;
    }

    public function addArticleCategory(ArticleCategory $articleCategory): self
    {
        if (!$this->article_category->contains($articleCategory)) {
            $this->article_category[] = $articleCategory;
            $articleCategory->setArticle($this);
        }

        return $this;
    }

    public function removeArticleCategory(ArticleCategory $articleCategory): self
    {
        if ($this->article_category->contains($articleCategory)) {
            $this->article_category->removeElement($articleCategory);
            // set the owning side to null (unless already changed)
            if ($articleCategory->getArticle() === $this) {
                $articleCategory->setArticle(null);
            }
        }

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
