<?php
require_once(__DIR__ . '/../../lib/base/model.php'); 
require_once(__DIR__ . '/TaskModel.php'); 
class ToDoModel {

    protected array $currentTasks;
    
    //Metodo para pasar del json al array
    public function getTasks(){   //obtener Task
        $filePath = __DIR__ . '/db/toDo.json';
        if (!file_exists($filePath)) {
            file_put_contents($filePath, '[]'); // Crea un archivo JSON vacío si no existe
        }
        $this->currentTasks = json_decode(file_get_contents($filePath), true);
        return $this->currentTasks;
    }
    // Método para obtener el último ID de tarea
    public function getLastTaskId(): int {
        $currentTasks = $this->getTasks();
        if (empty($currentTasks)) {
            return 0; // Si no hay tareas, se devuelve 0
        } else {
            $lastTask = end($currentTasks);
            return $lastTask['taskId'];
        }
    }
    //CRUD
    //metodo create task
    public function createTask(Task $task){
        $currentTasks = $this->getTasks(); //obtenemos las tasks antes de agregar la nueva 
        $lastTaskId = $this->getLastTaskId();
        $newTaskId = $lastTaskId + 1;//por lo cual siempre comenzara en el uno el array
        // new task con cada atributo
        $newTask = [
            // recogemos los valores de los getters y lo pasamos a la clave del array asociativo
            "taskId"=>$newTaskId, 
            "taskName"=>$task->getTaskName(), 
            "creationDate"=>$task->getCreationDate(), 
            "deadline"=>$task->getDeadline(), 
            "status"=>$task->getStatus(),
            "createdBy"=>$task->getCreatedBy()
        ];
        
        $currentTasks []= $newTask; // se inserta la tarea en el array de $arrayTasks
          // Intentamos escribir el array actualizado en el archivo JSON
        if ($this->addJsonFile($currentTasks)) {
            return true; // La tarea se agregó correctamente
        } else {
            return false; // Hubo un error al escribir en el archivo JSON
        }
        //$this->addJsonFile($currentTasks);// codificamos el array $arrayTasks en  archivo Json 
    }
//Metodo para agregar al archivo json 
 public function addJsonFile($currentTasks){ //agregar al json
    //$currentTasks = json_decode(file_get_contents(__DIR__ . '/db/toDo.json'), true);
    //$updatedTasks = array_merge($currentTasks, $arrayTasks); // Combina los arrays correctamente
     // Debugging
       // var_dump($currentTasks); // Muestra las tareas actuales
        //var_dump($arrayTasks);   //  nuevas tareas
        //var_dump($updatedTasks); // tareas actualizadas
            
    file_put_contents(__DIR__ . '/db/toDo.json', json_encode($currentTasks, JSON_PRETTY_PRINT)); // Utiliza $updatedTasks
}

//metodo delete task
    public function deleteTask(int $taskId){
        $currentTasks = $this->getTasks();
        $posicionToDelete= null;
        //en lugar del while probare con un foreach
        foreach ($currentTasks as $posicion => $task){
            if ($task["taskId"]== $taskId){
                $posicionToDelete= $posicion;
                break;
            }
        }
        if ($posicionToDelete !== null) {
            //unset($currentTasks[$posicionToDelete]); //elimino la posicion con unset
            array_splice($currentTasks, $posicionToDelete, 1);
            $currentTasks = array_values($currentTasks);// y reorganizo la posicion de los indices antes de guardar json
            $this->addJsonFile($currentTasks); //se agrega al json
    } 
}
  
//metodo search task
public function searchTask(int $taskId): array {
    $currentTasks = $this->getTasks();
    $taskFound = [];
    $found = false;
    $longArray = count($currentTasks);
    $i = 0;
    while (!$found && $i < $longArray) {
        if ($currentTasks[$i]["taskId"] == $taskId) {
            $taskFound = $currentTasks[$i];
            $found = true;
        }
        $i++;
    }
    return $taskFound; // Devuelve un arreglo vacío 
}

//metodo update task
public function updateTask(array $updatedTask){

        $currentTasks = $this->getTasks();
        //var_dump($currentTasks);
        $found = false;
        foreach ($currentTasks as &$task) {
            if ($task["taskId"] == $updatedTask["taskId"]) {
                $task = array_merge($task, $updatedTask);
                $found = true;
                break; // Termina el bucle una vez que se encuentra la tarea
            }
        }
    
        if ($found) {
            // Actualiza el archivo JSON con las tareas actualizadas
            $this->addJsonFile($currentTasks);
            return true; //si la tarea fue actualizada 
        } else {
            return false; //si no se encontró la tarea 
        }
    }

 
}
$todoModel = new ToDoModel();
//Probar que el crud funcione correctamente
/*
$todoModel = new ToDoModel();
$currentTasks = $todoModel->getTasks();
var_dump($currentTasks);
$task1 = new Task(
    "Rename files", // Nombre de la tarea
    "2024-02-05 10:00:00", // Fecha de creación
    "2024-02-10 12:00:00", // Fecha límite
    TaskStatus::DONE, // Estado de la tarea
    "Maria Jose" // Creador de la tarea
);

$todoModel->createTask($task1);
$todoModel->updateTask($currentTasks);

//$todoModel->createTask($newTask);
//$currentTasks = $todoModel->getTasks();
//var_dump($currentTasks);

//$taskIdToDelete = 2; // Cambiar por el ID de la tarea que deseas eliminar
//$todoModel->deleteTask($taskIdToDelete);
//$currentTasks = $todoModel->getTasks();
//var_dump($currentTasks);

//$taskIdToSearch = 1; // Cambiar por el ID de la tarea que deseas buscar
//$foundTask = $todoModel->searchTask($taskIdToSearch);
//var_dump($foundTask);
/*
$taskIdToUpdate = 3; // Cambiar por el ID de la tarea que deseas actualizar
$updatedTaskData = [
    "taskId" => $taskIdToUpdate,
    "taskName" => "Revisar correos electrónicos",
    "creationDate" => "2024-02-18 09:00:00",
    "deadline" => "2024-02-19 12:00:00",
    "status" => TaskStatus::IN_PROGRESS,
    "createdBy" => "Pedro"
];

$todoModel->updateTask($updatedTaskData);
$currentTasks = $todoModel->getTasks();
echo '<pre>';
var_dump($currentTasks);
echo '</pre>';
*/
/*
$todoModel = new ToDoModel();
$taskIdToDelete = 0; // Cambiar por el ID de la tarea que deseas eliminar
echo "esta es la tarea en la posicion que le envie: ";
var_dump($taskIdToDelete);
$currentTasks = $todoModel->getTasks();
var_dump($currentTasks[0]);

$todoModel->deleteTask($taskIdToDelete);

$currentTasks = $todoModel->getTasks();
echo "Estas son las que aun continuan: ";
var_dump($currentTasks);
*/


/* //esto verifica que si se puede eliminar el primer elemento de la lista
$todoModel = new ToDoModel();
var_dump($currentTasks = $todoModel->getTasks());

$taskIdToDelete = 1; // Cambiar por el ID de la tarea que deseas eliminar
echo "esta es la tarea en la posicion que le envie: ";
var_dump($taskIdToDelete);
$currentTasks = $todoModel->getTasks();
//var_dump($currentTasks[1]);
$todoModel->deleteTask($taskIdToDelete);
var_dump($currentTasks = $todoModel->getTasks());
*/

/*
$todoModel = new ToDoModel();
$currentTasks = $todoModel->getTasks();
var_dump($currentTasks);

$taskIdToDelete = 2; // Cambiar por el ID de la tarea que deseas eliminar
$todoModel->deleteTask($taskIdToDelete);
$currentTasks = $todoModel->getTasks();
var_dump($currentTasks);
*/