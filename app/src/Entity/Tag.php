<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleTag", mappedBy="tag", orphanRemoval=true)
     */
    private $article_tag;

    public function __construct()
    {
        $this->ArticleTag = new ArrayCollection();
        $this->article_tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $articleTag->setTag($this);
        }

        return $this;
    }

    public function removeArticleTag(ArticleTag $articleTag): self
    {
        if ($this->article_tag->contains($articleTag)) {
            $this->article_tag->removeElement($articleTag);
            // set the owning side to null (unless already changed)
            if ($articleTag->getTag() === $this) {
                $articleTag->setTag(null);
            }
        }

        return $this;
    }
}
