<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="author",fetch="EAGER")
     */
    private $books;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voteauthor", mappedBy="author", orphanRemoval=true)
     */
    private $uservotes;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->uservotes = new ArrayCollection();
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRating()
    {
        $sum = 0;
        foreach($this->getUservotes() as $vote){
            $sum += $vote->getVote();
        }

        return ($sum != 0 ? $sum/$this->getUservotes()->count() : -1);
    }

    public function getVotes()
    {
        return $this->getUservotes()->count();
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setAuthorId($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            // set the owning side to null (unless already changed)
            if ($book->getAuthorId() === $this) {
                $book->setAuthorId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Voteauthor[]
     */
    public function getUservotes(): Collection
    {
        return $this->uservotes;
    }

    public function addUservote(Voteauthor $uservote): self
    {
        if (!$this->uservotes->contains($uservote)) {
            $this->uservotes[] = $uservote;
            $uservote->setAuthor($this);
        }

        return $this;
    }

    public function removeUservote(Voteauthor $uservote): self
    {
        if ($this->uservotes->contains($uservote)) {
            $this->uservotes->removeElement($uservote);
            // set the owning side to null (unless already changed)
            if ($uservote->getAuthor() === $this) {
                $uservote->setAuthor(null);
            }
        }

        return $this;
    }
}
