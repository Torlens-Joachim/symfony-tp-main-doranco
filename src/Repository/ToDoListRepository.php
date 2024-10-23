<?php
namespace App\Repository;

use App\Entity\ToDoList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ToDoListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToDoList::class);
    }

    public function saveToDo(ToDoList $newToDoList, ?bool $isSave): ?ToDoList
    {
        
        $this->getEntityManager()->persist($newToDoList);
        if ($isSave) {
            $this->getEntityManager()->flush();
        }
        return $newToDoList;
    }

    public function removeToDoRepository(ToDoList $toDoList): void
    {

        $this->getEntityManager()->remove($toDoList);
        $this->getEntityManager()->flush();
    }
}