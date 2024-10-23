<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ToDoListRepository;

#[ORM\Entity(repositoryClass: ToDoListRepository::class)]
class ToDoList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $course = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $date = null;

    #[ORM\OneToMany(
        targetEntity: Task::class,
        mappedBy: "toDoList",
        cascade: ["persist", "remove"]
    )]
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

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

    public function getCourse(): ?string
    {
        return $this->course;
    }
    public function setCourse($course): self
    {
        $this->course = $course;
        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getTask()
    {
        return $this->tasks;
    }

    public function setTask($tasks): self
    {
        $this->tasks = $tasks;
        return $this;
    }

    function addTask(Task $task): void
    {
        $task->setToDoList($this);
        $this->tasks->add($task);
    }
}
