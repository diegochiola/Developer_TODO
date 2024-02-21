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
		'/tasksList'=> 'Task#tasksListViews',
		
		// Borrar Tarea
		'/deleteTask' => 'Task#deleteTaskAction',
		// Insertar una nueva tarea
		'/createTask'=> 'Task#createTaskAction',
		// Pre-edicion de una tarea
		'/UpdateTaskViews'=> 'Task#UpdateTaskViews',//UpdateTask está vinculada a UpdateTaskViews en el controlador TaskController.
		// Edicion tarea
		'/updateTask'=>'Task#updateTaskAction',//updateTask está vinculada a updateTaskAction en el controlador TaskController.

		
		//'/updateTask_views' => 'TaskController#updateTaskAction',
);
