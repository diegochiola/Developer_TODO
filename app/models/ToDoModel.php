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
        $currentTasks = json_decode(file_get_contents($filePath), true);
        return $this->currentTasks = $currentTasks;
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
        $newTaskId = $lastTaskId + 1;
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
        $this->addJsonFile($currentTasks);// codificamos el array $arrayTasks en  archivo Json 
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
        $found = false;
        $longArray = count($currentTasks);
        $i=0;
        while($found==false && $i<$longArray)             
        {
            if($currentTasks[$i]["taskId"]==$taskId)
            {//se elimina posicion de  tarea en el array
                array_splice($currentTasks,$i, 1);
                $found = true;//cuando encuentre tarea pasa a true
            }
            $i++;
        }

        $this->addJsonFile($currentTasks); //se agrega al json
    }
    /*public function deleteTask(int $taskId){
        //buscar la tarea primero:
        $taskToDelete = $this->searchTask($taskId);//utilizo metodo searchTask
        if ($taskToDelete) {
            // Obtener todas las tareas actuales
            $currentTasks = $this->getTasks();
            $updatedTasks = array_filter($currentTasks, function($task) use ($taskId) {
                return $task["taskId"] !== $taskId;
            });
            // actualizo json
            file_put_contents(__DIR__ . '/db/toDo.json', json_encode(array_values($updatedTasks), JSON_PRETTY_PRINT));
            
            echo "TaskId $taskId deleted succesfully.";
        } else {
            echo "Impossible to find taskId $taskId.";
        }
    }*/
//metodo search task
public function searchTask(int $taskId): array{
    $currentTasks = $this->getTasks();
    $found = false;
    $longArray = count($currentTasks);
    $i=0;
    while($found==false && $i<$longArray)             
    {
        if($currentTasks[$i]["taskId"]==$taskId)
        {
            $taskFound = $currentTasks[$i];
            $found = true;//cuando encuentre la tarea pasa a true
        }
        $i++;
    }
    return $taskFound; //devuelve la tarea encontrada que coincide con el task id
}

//metodo update task
public function updateTask(array $updatedTask){

        $currentTasks = $this->getTasks();
        //var_dump($currentTasks);
        $found = false;
        $longArray = count($currentTasks);
        $i=0;
        while($found==false && $i<$longArray){
            if($currentTasks[$i]["taskId"]==$updatedTask["taskId"])
            {   //sobreescribir datos nuevos
                $currentTasks[$i] = array_merge($currentTasks[$i], $updatedTask);
                $found = true;//se vuelve true cuando encuentra la tarea
            }
            $i++;
        }
       
        $this->addJsonFile($currentTasks);
    
}

 
}
//Probar que el crud funcione correctamente
$todoModel = new ToDoModel();
//$currentTasks = $todo->getTasks();
//var_dump($arrayTasks);
$newTask = new Task(
    "Change PC", // Nombre de la tarea
    "2024-02-19 10:00:00", // Fecha de creación
    "2024-02-20 12:00:00", // Fecha límite
    TaskStatus::DONE, // Estado de la tarea
    "Ricardo" // Creador de la tarea
);

//$todo->createTask($task1);
//$todo->updateTask($currentTasks);

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

/*$taskIdToUpdate = 3; // Cambiar por el ID de la tarea que deseas actualizar
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