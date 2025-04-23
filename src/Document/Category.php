<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

#[ODM\Document(collection: 'categories')]
class Category
{
    #[ODM\Id]
    protected string $id;
    #[ODM\Field(type: 'string')]
    #[Assert\NotBlank(message: 'El título no puede estar vacío')]
    #[Assert\Length(min: 3, max: 90, minMessage: 'El título debe tener al menos {{ limit }} caracteres', maxMessage: 'El título no puede tener más de {{ limit }} caracteres')]
    protected ?string $name;

    public function __toString(): string
    {
        return $this->getName();
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}