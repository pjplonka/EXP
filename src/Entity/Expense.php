<?php

namespace App\Entity;

use App\Repository\ExpenseRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity(repositoryClass: ExpenseRepository::class)]
class Expense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public string $name;

    #[ORM\Column(length: 255)]
    public int $amount;

    #[ORM\Column(type: 'boolean')]
    public bool $isPaid;

    #[ORM\Column(type: 'date_immutable')]
    public DateTimeImmutable $date;

    #[ManyToMany(targetEntity: Label::class, inversedBy: 'expenses')]
    #[JoinTable(name: 'expenses_labels')]
    public Collection $labels;

    public function getId(): ?int
    {
        return $this->id;
    }
}
