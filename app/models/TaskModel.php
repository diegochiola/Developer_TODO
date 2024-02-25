<?php
//Finalmente realice la clase TaskStatus:
require_once 'TaskStatus.php';

class Task{

    protected int $taskId;
    protected string $taskName;
    protected string $creationDate;
    protected string $deadline;
    //public TaskStatus $status;
    protected string $status;
    protected string $createdBy;

    public function __construct(string $taskName, string $creationDate,string $deadline,string $status,string $createdBy){
        $this->taskId = $this->getLastTaskId() + 1;
        $this->taskName = $taskName;
        $this->creationDate = $creationDate;
        $this->deadline = $deadline;
        $this->status= $status;
        $this->createdBy= $createdBy;

    }
    //metodo para obtener el ultimo id designado
    public function getLastTaskId(): int{
        //agregar el caso que no exista ningun id 
        $tasks= json_decode(file_get_contents(__DIR__ . '/db/toDo.json'), true);
        if (empty($tasks)) {
            return 0;
        } else {
        $lastTask = end($tasks);
        $lastTaskId = $lastTask["taskId"];
        return $lastTaskId;
        }
    }

    //definicion de metodos getter/setter
    public function getTaskId(): int {
    return $this->taskId;
    } 

    public function setTaskId(int $taskId){
        $this->taskId = $taskId;
    }

    public function getTaskName(): string{
        return $this->taskName;
    }
    public function setTaskName(string $taskName){
        $this->taskName = $taskName;
        return $this;
    }

    public function getCreationDate(): string{
        return $this->creationDate;
    }
    public function setCreationDate(string $creationDate){
        $this->creationDate = $creationDate;
        return $this;
    }

    public function getDeadline(): string{
        return $this->deadline;
    }
    public function setDeadline(string $deadline){
        $this->deadline = $deadline;
        return $this;
    }

    public function getStatus(): string{
        return (string) $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }
    public function getCreatedBy(): string {
        return $this->createdBy;
    } 
    public function setCreatedBy(string $createdBy){
        $this->createdBy = $createdBy;
        return $this;
    }

 
 // Método para establecer todos los atributos de la tarea a la vez
 public function setAttributes(array $attributes) {
    foreach ($attributes as $key => $value) {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
    return $this;
}
}

/* Probar el metodo setAttributes
$task = new Task("Repasar Examen", '2024-02-18 15:30:00', '2024-02-24 11:30:00', TaskStatus::TO_DO, "Laura Jimenez");
$task->setAttributes([
'status' => TaskStatus::DONE,
'createdBy' => 'Juan Perez'
]);

// Verificar los cambios
var_dump($task->getStatus());  
var_dump($task->getCreatedBy()); 

//probar clase
/*
$task = new Task("Repasar Examen",'2024-02-18 15:30:00', '2024-02-24 11:30:00', taskStatus::TO_DO, "Laura Jimenez"  );
var_dump($task->getTaskId());
var_dump($task->getTaskName());
var_dump($task->getCreationDate());
var_dump($task->getStatus());

$draft =TaskStatus::DONE;
echo $draft->getColor();
echo $draft->value;
foreach(TaskStatus::cases()as $enum){
    echo $enum->value;
}*/