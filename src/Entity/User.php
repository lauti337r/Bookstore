<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $googleId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilePic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cart", cascade={"persist", "remove"})
     */
    private $cart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voteauthor", mappedBy="user", orphanRemoval=true)
     */
    private $voteauthors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Votebook", mappedBy="user", orphanRemoval=true)
     */
    private $votebooks;

    public function __construct()
    {
        $this->voteauthors = new ArrayCollection();
        $this->votebooks = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(){
        return $this->firstName;
    }


    public function setLastName($lastName){
        $this->lastName = $lastName;
        return $this;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(){
        return $this->lastName;
    }
    public function getProfilePic(){
        return $this->profilePic;
    }

    public function setProfilePic($profilePic){
        $this->profilePic = $profilePic;
        return $this;
    }
    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles()
    {
        return array($this->role);
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt(string $salt){
        $this->salt = $salt;
        return $this;
    }
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(){
        return $this->role;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * @return Collection|Voteauthor[]
     */
    public function getVoteauthors(): Collection
    {
        return $this->voteauthors;
    }

    public function addVoteauthor(Voteauthor $voteauthor): self
    {
        if (!$this->voteauthors->contains($voteauthor)) {
            $this->voteauthors[] = $voteauthor;
            $voteauthor->setUser($this);
        }

        return $this;
    }

    public function removeVoteauthor(Voteauthor $voteauthor): self
    {
        if ($this->voteauthors->contains($voteauthor)) {
            $this->voteauthors->removeElement($voteauthor);
            // set the owning side to null (unless already changed)
            if ($voteauthor->getUser() === $this) {
                $voteauthor->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Votebook[]
     */
    public function getVotebooks(): Collection
    {
        return $this->votebooks;
    }

    public function addVotebook(Votebook $votebook): self
    {
        if (!$this->votebooks->contains($votebook)) {
            $this->votebooks[] = $votebook;
            $votebook->setUser($this);
        }

        return $this;
    }

    public function removeVotebook(Votebook $votebook): self
    {
        if ($this->votebooks->contains($votebook)) {
            $this->votebooks->removeElement($votebook);
            // set the owning side to null (unless already changed)
            if ($votebook->getUser() === $this) {
                $votebook->setUser(null);
            }
        }

        return $this;
    }
}
