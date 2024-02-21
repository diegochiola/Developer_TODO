<?php
/*//defino constante ROOT_PATH 
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../'));
}*/
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
        // Aquí puedes realizar cualquier lógica adicional si es necesario
       //echo "Including index.php from: " . ROOT_PATH . '/web/index.php' . "<br>";
        //include(ROOT_PATH . '/web/index.php');
       
    }

    public function insertTaskAction(){
        //var_dump("HOOLA");
        //exit(0);
    // Verificar si se enviaron todos los campos necesarios y si tienen un formato válido
    $requiredFields = ['taskName', 'creationDate', 'deadline', 'status', 'createdBy'];
    $errors = []; //dafino variable errores
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $errors[] = "Error: The field '$field' is required.";
           
        }
        //pendiente validar algun campo mas para que no pete la app
    }
    if (!empty($errors)) {
        return $this->view->render('error_view.php', ['errors' => $errors]);
    }
    
    //procesar los datos
    $taskName = $_POST["taskName"];
    $creationDate = $_POST["creationDate"];
    $deadline = $_POST["deadline"];
    $status = $_POST["status"];
    $createdBy = $_POST["createdBy"];

    $task = new Task($taskName, $creationDate, $deadline, $status, $createdBy);

    // Llamar al método createTask de ToDoModel y pasarle el objeto Task
    $this->toDo->createTask($task);

    // Redirigir a tasksList
    //header("Location: /");
    //exit();
}

    public function tasksListViewsAction() {
        $currentTasks = $this->toDo->getTasks();
        // Imprimir los datos obtenidos
        //var_dump($currentTasks);
       //return $currentTasks;
        $this->view->currentTasks = $currentTasks;
    }
    
    
    public function deleteTaskAction() {
        if(isset($_GET["taskId"])){
            $taskId = $_GET["taskId"];
            $toDo = $this->toDo;
            $toDo->deleteTask($taskId);
            header("Location: /tasksList");
            exit();
        }else{
            echo "Root Error";
        }    
    }



   public function UpdateTaskViewsAction(){

        if (isset($_GET["taskId"])) {
            $taskId = $_GET["taskId"];
            $tasksFound = $this->toDo->searchTask($taskId);  
            return $tasksFound; 
        } else {
            // Manejar el caso en que taskId no está definido
            return $this->view->render('error_view.php', ['error' => 'Task ID is not defined.']);
        }
    }

    public function updateTaskAction(){
        if(isset($_POST["taskId"])){    
           //MOSTRAR LO QUE SE INGRESA
            //echo "<pre>";
            //print_r($_POST); // Muestra los datos recibidos del formulario
            //echo "</pre>";
            $toDo = $this->toDo;
            //se toman todos los valores ingresados de la vista updateTask
                $taskId= (int) $_POST["taskId"];//casteamos el valor a int ya que el POST lo devuelve como string
                $taskName= $_POST["taskName"];
                $creationDate= $_POST["creationDate"];
                $deadline= $_POST["deadline"];
                $status= $_POST["status"];
                $createdBy= $_POST["createdBy"];
    
            $updatedTask =[
                "taskId" =>$taskId,
                "taskName" =>$taskName,
                "creationDate" =>$creationDate,
                "deadline" =>$deadline,
                "status" =>$status,
                "createdBy" =>$createdBy
            ];

            // var_dump($updatedTask);

            if ($toDo->updateTask($updatedTask)) {
                header("Location: /tasksList");
                exit();
            } else {
                // Manejar el caso en que la actualización falla
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

// Llamar método deleteTaskAction()
var_dump($controller->deleteTaskAction());

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
