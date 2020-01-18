<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="subcategories")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parent")
     */
    private $subcategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleCategory", mappedBy="category", orphanRemoval=true)
     */
    private $article_category;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
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
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(self $subcategory): self
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories[] = $subcategory;
            $subcategory->setParent($this);
        }

        return $this;
    }

    public function removeSubcategory(self $subcategory): self
    {
        if ($this->subcategories->contains($subcategory)) {
            $this->subcategories->removeElement($subcategory);
            // set the owning side to null (unless already changed)
            if ($subcategory->getParent() === $this) {
                $subcategory->setParent(null);
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
            $articleCategory->setCategory($this);
        }

        return $this;
    }

    public function removeArticleCategory(ArticleCategory $articleCategory): self
    {
        if ($this->article_category->contains($articleCategory)) {
            $this->article_category->removeElement($articleCategory);
            // set the owning side to null (unless already changed)
            if ($articleCategory->getCategory() === $this) {
                $articleCategory->setCategory(null);
            }
        }

        return $this;
    }
}
