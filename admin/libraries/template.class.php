<?php

/**
 * Provide the smallest and simplest PHP templating engine ever
 */
class Template {

	private $vars = array();
	private $view_template_file;

	public function __construct($view_template_file)
	{
		$this->view_template_file = $view_template_file;
	}

	public function __get($name)
	{
		return $this->vars[$name];
	}

	public function __set($name, $value)
	{
		if($name == 'view_template_file') {
			throw new Exception("Cannot bind variable named 'view_template_file'");
		}
		$this->vars[$name] = $value;
	}

	public function render()
	{
		extract($this->vars);
		ob_start();
		include($this->view_template_file);
		return ob_get_clean();
	}
}
