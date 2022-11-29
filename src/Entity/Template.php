<?php

namespace App\Entity;

use App\Repository\TemplateRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity(repositoryClass: TemplateRepository::class)]
class Template
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public string $name;

    #[ORM\Column(length: 255)]
    public int $amount;

    #[ManyToMany(targetEntity: Label::class, inversedBy: 'templates')]
    #[JoinTable(name: 'templates_labels')]
    public Collection $labels;

    public function getId(): ?int
    {
        return $this->id;
    }
}
