<?php

require_once(__DIR__ . '../../models/ToDoModel.php');
//var_dump("ToDoModel included successfully");
require_once(__DIR__ . '../../models/TaskModel.php');
//var_dump("TaskModel included successfully");
require_once(__DIR__ . '/../../lib/base/Controller.php');
//var_dump("Controller included successfully");
require_once(__DIR__ . '/../../lib/base/View.php');

class TaskController extends Controller{

    private $toDo;
    public $view;

    public function __construct()
    {
        $this->toDo =  new ToDoModel();  
        $this->view = new View();
    }
    public function indexAction() {
       
       //echo "Including index.php from: " . ROOT_PATH . '/web/index.php' . "<br>";
        //include(ROOT_PATH . '/web/index.php');
       
    }
public function create_task_viewsAction(){   
    
}

 public function create_taskAction() { 
        $requiredFields = ['taskName', 'creationDate', 'deadline', 'status', 'createdBy'];
        $errors = [];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                $errors[] = "Error: The field '$field' is required.";
            }
        }
       
        if (empty($errors)) {
            // Accede a los datos del formulario de manera segura
            $taskName = ucwords(strtolower($_POST["taskName"]));//para segurarme de que no escriban todo en mayus
            $creationDate = $_POST["creationDate"];
            $deadline = $_POST["deadline"];
            $status = $_POST["status"];
            $createdBy = ucwords(strtolower($_POST["createdBy"]));
    
            // Crea una nueva instancia 
            $task = new Task($taskName, $creationDate, $deadline, $status, $createdBy);
    
            // Llama al método createTask del modelo ToDoModel 
            $this->toDo->createTask($task);
    
            // retorna a lista de tareas 
            header("Location: tasks_list_views");
            exit();
        } else {
            // mostrar un mensaje de error al usuario
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    }


   public function tasks_list_viewsAction() {
        $currentTasks = $this->toDo->getTasks();
        // Imprimir los datos obtenidos
        //var_dump($currentTasks);
       //return $currentTasks;
       //probar solucionar que muestre los valores en lugar de la constante:
       
        $this->view->currentTasks = $currentTasks;
    }

 // Convertir el estado de las tareas a su representación de cadena


    //probar con POST rn lugar de GET
    public function delete_taskAction() {
        //var_dump($_POST);
        //var_dump($_POST['taskId']);
            if (isset($_POST['taskId'])) {
                $taskId = $_POST['taskId'];
                //var_dump($taskId);
                //echo "Task ID to delete: " . $taskId; 
                $this->toDo->deleteTask($taskId);
                header("Location: tasks_list_views");
                exit();
            } 
       
    }


   public function update_task_viewsAction(){
    if (isset($_GET["taskId"])) {
        $taskId = $_GET["taskId"];
        $tasksFound = $this->toDo->searchTask($taskId);  
        $this->view->tasksFound = $tasksFound; //se asigna a la vistallevando los datos del id
        return $this->view->render('task/updateTaskViews.phtml'); // y la renderiza
    } else {
        header("Location: tasks_list_views");
        exit();
    }
}

    public function update_taskAction() {
        if (isset($_POST["taskId"])) {
            $taskId = (int) $_POST["taskId"];
            $taskName = ucwords(strtolower($_POST["taskName"]));
            $creationDate = $_POST["creationDate"];
            $deadline = $_POST["deadline"];
            $status = $_POST["status"];
            $createdBy = ucwords(strtolower($_POST["createdBy"]));
            
            //nuevo array
            $updatedTask = [
                "taskId" => $taskId,
                "taskName" => $taskName,
                "creationDate" => $creationDate,
                "deadline" => $deadline,
                "status" => $status,
                "createdBy" => $createdBy
            ];

            if ($this->toDo->updateTask($updatedTask)) {
                //header("Location: /tasksList");
                //header("Location: " . WEB_ROOT . "/tasksList");
                //return $this->view->render('tasksListViews.phtml'); 
            // Redirige al usuario a la lista de tareas después de crear la tarea
            header("Location: tasks_list_views");
            exit();
            } 
        }
    }
    //metodo para buscaer tarea por id
    public function task_foundAction($taskId) {
        $taskId = $_GET["taskId"];
        $tasksFound = $this->toDo->searchTask($taskId);
        return $tasksFound;
    }


}


//debug
//$controller = new TaskController();
//var_dump($_POST['taskId']);
//$controller->delete_taskAction();
//var_dump($controller->tasks_list_viewsAction());
//$controller->delete_taskAction(0);

/*
// Llamar método indexAction()
var_dump($controller->indexAction());

// Llamar método insertTaskAction() 
var_dump($controller->insertTaskAction());

// Llamar método tasksListViewsAction() 
var_dump($controller->tasksListViewsAction());
*/
// Llamar método deleteTaskAction()
//$controller = new TaskController();
//var_dump($controller->deleteTaskAction(12));
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
