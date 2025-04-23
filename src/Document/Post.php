<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

#[MongoDB\Document(collection: 'post')]
class Post
{
    #[MongoDB\Id]
    protected string $id;

    #[MongoDB\Field(type: 'string')]
    #[Assert\NotBlank(message: 'El título no puede estar vacío')]
    #[Assert\Length(min: 9, max: 90, minMessage: 'El título debe tener al menos {{ limit }} caracteres', maxMessage: 'El título no puede tener más de {{ limit }} caracteres')]
    protected ?string $title;

    #[MongoDB\Field(type: 'string')]
    #[Assert\NotBlank(message: 'El contenido no puede estar vacío')]
    protected ?string $body;
    #[MongoDB\ReferenceOne(targetDocument: Category::class)]
    #[Assert\NotNull(message: 'La categoría no puede estar vacía')]
    protected ?Category $category;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }
}