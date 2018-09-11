<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books",fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genre", inversedBy="books")
     * @ORM\JoinTable(name="genre_book")
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="book", orphanRemoval=true)
     */
    private $details;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Votebook", mappedBy="book", orphanRemoval=true)
     */
    private $uservotes;


    public function getRating(){
        $sum = 0;
        foreach($this->getUservotes() as $vote){
            $sum += $vote->getVote();
        }
        return $sum/$this->getVotes();
    }


    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->details = new ArrayCollection();
        $this->uservotes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author){
        $this->author = $author;
        return $this;
    }

    public function setAuthorId(?Author $authorId): self
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }
    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
            $genre->addBook($this);
        }
        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
            $genre->removeBook($this);
        }

        return $this;
    }



    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getVotes(){
        return $this->getUservotes()->count();
    }


    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setBook($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getBook() === $this) {
                $detail->setBook(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Collection|Votebook[]
     */
    public function getUservotes(): Collection
    {
        return $this->uservotes;
    }

    public function addUservote(Votebook $uservote): self
    {
        if (!$this->uservotes->contains($uservote)) {
            $this->uservotes[] = $uservote;
            $uservote->setBook($this);
        }

        return $this;
    }

    public function removeUservote(Votebook $uservote): self
    {
        if ($this->uservotes->contains($uservote)) {
            $this->uservotes->removeElement($uservote);
            // set the owning side to null (unless already changed)
            if ($uservote->getBook() === $this) {
                $uservote->setBook(null);
            }
        }

        return $this;
    }
}
