<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */
$routes = array(
	// HOME/INDEX
	'/' => 'Task#index',
	// TASKS:
		// Listar todas las tareas
		'/tasks_list_views'=> 'Task#tasks_list_views',
		
		// Borrar Tarea
		'/delete_task' => 'Task#delete_task',
		
		// ir a la vista create Task
		'/create_task_views'=> 'Task#create_task_views',
		// MANDAR FORMULARIO CREATE TASK AL CONTROLLER POR EL SUBMIT
		'/create_task'=> 'Task#create_task',

		// ir a la vista update task
		'/update_task_views'=> 'Task#update_task_views',
		// MANDAR FORMULARIO update TASK AL CONTROLLER POR EL SUBMIT
		'/update_task'=>'Task#update_task',

		
		//'/updateTask_views' => 'TaskController#updateTaskAction',
);
