<?php

namespace App\Entity;

use App\Repository\WriterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WriterRepository::class)]
class Writer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
