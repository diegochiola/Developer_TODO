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
		'/UpdateTask'=> 'Task#UpdateTaskViews',
		// Edicion tarea
		'/updateTask'=>'Task#updateTaskAction',
		
		//'/updateTask_views' => 'TaskController#updateTaskAction',
);
