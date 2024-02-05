<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $total = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Detail::class, cascade: ['persist'] )]
    private Collection $details;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adresse_Livraison = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adresse_Facturation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Paiement = null;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setCommande($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getCommande() === $this) {
                $detail->setCommande(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresse_Livraison;
    }

    public function setAdresseLivraison(?string $adresse_Livraison): static
    {
        $this->adresse_Livraison = $adresse_Livraison;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresse_Facturation;
    }

    public function setAdresseFacturation(?string $adresse_Facturation): static
    {
        $this->adresse_Facturation = $adresse_Facturation;

        return $this;
    }

    public function getPaiement(): ?string
    {
        return $this->Paiement;
    }

    public function setPaiement(?string $Paiement): static
    {
        $this->Paiement = $Paiement;

        return $this;
    }

}