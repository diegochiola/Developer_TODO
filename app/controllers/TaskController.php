<?php

require_once(__DIR__ . '../../models/ToDoModel.php');
//var_dump("ToDoModel included successfully");
require_once(__DIR__ . '../../models/TaskModel.php');
//var_dump("TaskModel included successfully");
require_once(__DIR__ . '/../../lib/base/Controller.php');
//var_dump("Controller included successfully");


class TaskController extends Controller{

    private $toDo;

    public function __construct()
    {
        $this->toDo =  new ToDoModel();  
    }
    public function indexAction() {
       
       //echo "Including index.php from: " . ROOT_PATH . '/web/index.php' . "<br>";
        //include(ROOT_PATH . '/web/index.php');
       
    }

 public function createTaskAction() { //createTaskActionAction a ver si se soluciona el error
        $requiredFields = ['taskName', 'creationDate', 'deadline', 'status', 'createdBy'];
        $errors = [];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                $errors[] = "Error: The field '$field' is required.";
            }
        }
       
        if (empty($errors)) {
            // Accede a los datos del formulario de manera segura
            $taskName = $_POST["taskName"];
            $creationDate = $_POST["creationDate"];
            $deadline = $_POST["deadline"];
            $status = $_POST["status"];
            $createdBy = $_POST["createdBy"];
    
            // Crea una nueva instancia de la clase Task con los datos proporcionados
            $task = new Task($taskName, $creationDate, $deadline, $status, $createdBy);
    
            // Llama al método createTask del modelo ToDoModel para guardar la nueva tarea
            $this->toDo->createTask($task);
    
            // Redirige al usuario a la lista de tareas después de crear la tarea
            header("Location: /tasksList");
            exit();
        } else {
            // Si hay errores, podrías manejarlos de alguna manera, como mostrar un mensaje de error al usuario
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    }


    public function tasksListViewsAction() {
        $currentTasks = $this->toDo->getTasks();
        // Imprimir los datos obtenidos
        //var_dump($currentTasks);
       //return $currentTasks;
        $this->view->currentTasks = $currentTasks;
    }
    //probar con POST rn lugar de GET
    public function deleteTaskAction() {
        if(isset($_POST["taskId"])) {
            $taskId = $_POST["taskId"];
            $this->toDo->deleteTask($taskId);
            header("Location: /tasksList");
            exit();
        } else {
            echo "Root Error";
        }    
    }
    
    /*public function deleteTaskAction() {
        
        if(isset($_GET["taskId"])){
            $taskId = $_GET["taskId"];
            $this->toDo->deleteTask($taskId);
            header("Location: /tasksList");
            exit();
        }else{
            echo "Root Error";
        }    
    }
*/


   public function UpdateTaskViewsAction(){
    if (isset($_GET["taskId"])) {
        $taskId = $_GET["taskId"];
        $tasksFound = $this->toDo->searchTask($taskId);  
        $this->view->tasksFound = $tasksFound; //se asigna a la vista
    } else {
        return $this->view->render('error_view.php', ['error' => 'Task ID is not defined.']);
    }
}

public function updateTaskAction() {
    if (isset($_POST["taskId"])) {
        $taskId = (int) $_POST["taskId"];
        $taskName = $_POST["taskName"];
        $creationDate = $_POST["creationDate"];
        $deadline = $_POST["deadline"];
        $status = $_POST["status"];
        $createdBy = $_POST["createdBy"];

        $updatedTask = [
            "taskId" => $taskId,
            "taskName" => $taskName,
            "creationDate" => $creationDate,
            "deadline" => $deadline,
            "status" => $status,
            "createdBy" => $createdBy
        ];

        if ($this->toDo->updateTask($updatedTask)) {
            header("Location: /tasksList");
            exit();
        } else {
            return $this->view->render('error_view.php', ['error' => 'Failed to update task.']);
        }
    }
}
}
/*
//debug
$controller = new TaskController();

// Llamar método indexAction()
var_dump($controller->indexAction());

// Llamar método insertTaskAction() 
var_dump($controller->insertTaskAction());

// Llamar método tasksListViewsAction() 
var_dump($controller->tasksListViewsAction());
*/
// Llamar método deleteTaskAction()
$controller = new TaskController();
var_dump($controller->deleteTaskAction(12));
/*
// Llamar método updateTaskAction() 
var_dump($controller->updateTaskAction());


//$TaskController = new TaskController();
//$currentTasks = $TaskController->tasksList_viewsAction();
// $TaskController->editTaskAction($updateTask);
//var_dump($currentTasks);
//var_dump($_POST);
//$controller = new TaskController();
//$controller->insertTaskAction();
//var_dump($controller->indexAction());
*/
