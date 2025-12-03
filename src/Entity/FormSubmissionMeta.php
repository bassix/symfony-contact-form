<?php

namespace App\Entity;

use App\Repository\FormSubmissionMetaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormSubmissionMetaRepository::class)]
#[ORM\Table(name: 'form_submission_meta')]
class FormSubmissionMeta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $metaKey = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $metaValue = null;

    #[ORM\ManyToOne(targetEntity: FormContact::class, inversedBy: 'metadata')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormContact $formContact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetaKey(): ?string
    {
        return $this->metaKey;
    }

    public function setMetaKey(string $metaKey): static
    {
        $this->metaKey = $metaKey;

        return $this;
    }

    public function getMetaValue(): ?string
    {
        return $this->metaValue;
    }

    public function setMetaValue(?string $metaValue): static
    {
        $this->metaValue = $metaValue;

        return $this;
    }

    public function getFormContact(): ?FormContact
    {
        return $this->formContact;
    }

    public function setFormContact(?FormContact $formContact): static
    {
        $this->formContact = $formContact;

        return $this;
    }
}
