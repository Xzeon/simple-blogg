<?php

Class View {
	
	/**
	 * Renders the view with optional data.
	 * @param  string $view The name of the template to render.
	 * @param  mixed $data 	The data to be passed along to the template.
	 * @return void.
	 */
	public function render($view, $data = null){
		require_once 'views/' . $view . '.php';
	}
}