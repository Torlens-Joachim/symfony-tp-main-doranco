<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function saveTask(Task $newTask, ?bool $isSave): ?Task
    {
        $this->getEntityManager()->persist($newTask);
        if ($isSave) {
            $this->getEntityManager()->flush();
        }
        return $newTask;
    }

    public function removeTask(Task $newTask): void
    {

        $this->getEntityManager()->remove($newTask);
        $this->getEntityManager()->flush();
    }
}
