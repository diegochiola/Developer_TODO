<?php
require_once(__DIR__ . '../../models/ToDoModel.php');
//var_dump("ToDoModel included successfully");
require_once(__DIR__ . '../../models/TaskModel.php');
//var_dump("TaskModel included successfully");
require_once(__DIR__ . '/../../lib/base/Controller.php');
//var_dump("Controller included successfully");
require_once(__DIR__ . '/../../web/index.php');

class TaskController extends Controller{

    private $toDo;

    public function __construct()
    {
        $this->toDo =  new ToDoModel();  
    }
    public function indexAction() {
        // Aquí puedes realizar cualquier lógica adicional si es necesario
       //echo "Including index.php from: " . ROOT_PATH . '/web/index.php' . "<br>";
        include(ROOT_PATH . '/web/index.php');
       
    }

    public function insertTaskAction(){
            //var_dump("HOOLA");
            //exit(0);
        // Verificar si se enviaron todos los campos necesarios y si tienen un formato válido
        $requiredFields = ['taskName', 'creationDate', 'deadline', 'status', 'createdBy'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                echo "Error: The field '$field' is required.";
                return; // Detener la ejecución si falta algo
            }
            //pendiente validar algun campo mas para que no pete la app
        }
    
        //procesar los datos
        $taskName = $_POST["taskName"];
        $creationDate = $_POST["creationDate"];
        $deadline = $_POST["deadline"];
        $status = $_POST["status"];
        $createdBy = $_POST["createdBy"];
    
        $toDo = $this->toDo;
        $toDo->createTask(new Task($taskName, $creationDate, $deadline, $status, $createdBy));
        header("Location: /tasksList");// Redirige a taskslist
        exit();
    }
    public function tasksListViewsAction() {
        $currentTasks = $this->toDo->getTasks();
        // Imprimir los datos obtenidos
        //var_dump($currentTasks);
        return $currentTasks;
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



   /* public function UpdateTaskViewsAction(){

        if (isset($_GET["taskId"])) {
            $taskId = $_GET["taskId"];
            $tasksFound = $this->toDo->searchTask($taskId);  
            return $tasksFound; 
        }
    }*/

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

            $toDo->updateTask($updatedTask);

            header("Location: /tasksList");
            exit();
        }
    }


}

//$TaskController = new TaskController();
//$currentTasks = $TaskController->tasksList_viewsAction();
// $TaskController->editTaskAction($updateTask);
//var_dump($currentTasks);
//var_dump($_POST);
$controller = new TaskController();
//$controller->insertTaskAction();
var_dump($controller->indexAction());
