<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $authors;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: BookVersion::class)]
    private Collection $bookVersions;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->bookVersions = new ArrayCollection();
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
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    /**
     * @return Collection<int, BookVersion>
     */
    public function getBookVersions(): Collection
    {
        return $this->bookVersions;
    }

    public function addBookVersion(BookVersion $bookVersion): self
    {
        if (!$this->bookVersions->contains($bookVersion)) {
            $this->bookVersions->add($bookVersion);
            $bookVersion->setBook($this);
        }

        return $this;
    }

    public function removeBookVersion(BookVersion $bookVersion): self
    {
        if ($this->bookVersions->removeElement($bookVersion)) {
            // set the owning side to null (unless already changed)
            if ($bookVersion->getBook() === $this) {
                $bookVersion->setBook(null);
            }
        }

        return $this;
    }
}
