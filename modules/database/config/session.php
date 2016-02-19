<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	'cookie' => array(
		'name' => 'custom_session_name',
		'encrypted' => TRUE,
		'lifetime' => 60*30,
	),
	'database' => array(
		/**
		 * Database settings for session storage.
		 *
		 * string   group  configuration group name
		 * string   table  session table name
		 * integer  gc     number of requests before gc is invoked
		 * columns  array  custom column names
		 */
		'name'		=> 'session_database',
		'encrypted' => TRUE,
		'lifetime'  => 43200,
		'group'   => 'default',
		'table'   => 'sessions',
		'gc'      => 500,
		'columns' => array(
			/**
			 * session_id:  session identifier
			 * last_active: timestamp of the last activity
			 * contents:    serialized session data
			 */
			'session_id'  => 'session_id',
			'last_active' => 'last_active',
			'contents'    => 'contents'
		),
	),
);
