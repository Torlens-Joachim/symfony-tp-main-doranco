<?php
namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: "boolean")]
    private ?bool $isFinished = false;

    #[ORM\ManyToOne(targetEntity: ToDoList::class, inversedBy: 'tasks')]
    private $toDoList;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }
    public function setIsFinished($isFinished): self
    {
        $this->isFinished = $isFinished;
        return $this;
    }

    public function getToDoList(): ?ToDoList
    {
        return $this->toDoList;
    }

    public function setToDoList(ToDoList $toDoList): self
    {
        $this->toDoList = $toDoList;
        return $this;
    }
}