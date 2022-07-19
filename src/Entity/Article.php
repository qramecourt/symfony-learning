<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;//c'est ici qu'on peut accéder à la BDD

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]//correspond à la colonne id de la BDD
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 190)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $body;

    #[ORM\Column(type: 'datetime_immutable')]
    private $published_at;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'articles')]
    private $tags;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'articles')]
    private $category;

    public function __construct()
    {
        $this->tags = new ArrayCollection();//se comporte comme un tableau, mais c'est un objet avec ses méthodes
    }                                       //c'est le ArrayCollection qui permet de dire "ok il y a plusierus tags

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string //peut renvoyer null mais n'est pas nullable
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeImmutable $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;//ceci est un objet unique

        return $this;
    }
}
