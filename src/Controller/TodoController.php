<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\ToDoList;
use App\Repository\TaskRepository;
use App\Repository\ToDoListRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route("/to-do-list", name: "todolist", methods: "GET")]
    public function add_todo_page(ToDoListRepository $repo)
    {
        $todos = $repo->findAll();
        return $this->render("add-to-do-list.html.twig", [
            "tasks" => $todos
        ]);
    }

    #[Route("/processToDoList", name: "todolist.add", methods: "POST")]
    public function processAddToDoList(Request $req, ToDoListRepository $repo)
    {
        $name = $req->request->get("name");
        $course = $req->request->get("course");
        $tasks = $req->request->get("task");
        if (!isset($name) || !isset($course) || !isset($tasks) || $name == "" || $course == "" || $tasks == "") {
            return $this->render(
                "add-to-do-list.html.twig",
                ["success" => false, "message" => "Données obligatoires !"]
            );
        }

        $newToDoList = new ToDoList();
        $date = new DateTime();
        $task = new Task();
        $task->setName($tasks);
        $newToDoList->setName($name)->setCourse($course)->setDate($date)->addTask($task);
        $repo->saveToDo($newToDoList, true);

        $todos = $repo->findAll();
        return $this->render(
            "add-to-do-list.html.twig",
            [
                "success" => true,
                "message" => "Tâches bien enregistré !",
                "tasks" => $todos
            ]
        );
    }
    

    #[Route("/processIsFinished/{id}", name: "isFinished")]
    public function isFinished($id, TaskRepository $taskRepository)
    {
        $isFinished = $taskRepository->find($id);
        $getIsFinishedValue = $isFinished->getIsFinished();
        $isFinished->setIsFinished(!$getIsFinishedValue);

        $taskRepository->saveTask($isFinished, true);

        return $this->redirectToRoute('todolist');
    }

    #[Route("/processAddToDoListTask/{id}", name: "todolist.add.processAddToDoList", methods: "POST")]
    public function processAddTask($id, Request $req, TaskRepository $repo)
    {
        $tasks = $req->request->get("task");
        if (!isset($tasks) ||$tasks == "") {
            $todos = $repo->findAll();

            return $this->render(
                "add-to-do-list.html.twig",
                ["success" => false, "message" => "Données obligatoires !", "todos"=>$todos]
            );
        }

        $adding = $repo->find($id);
        
        $newTask = new Task();
        $newTask->setName($tasks);

        $adding->addTasks($newTask); 

        $repo->saveTask($adding, true);

        return $this->redirectToRoute('todosList');
    }


}
