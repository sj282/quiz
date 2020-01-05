<?php

class AutoLoad
{
	public function loadClass($class)
	{
		if (substr($class, -10) == 'Controller') {
			$directory = 'controllers';
		} else if (substr($class, -5) == 'Model') {
			$directory = 'models';
		}

		require "$directory/$class.php";
	}

	public function run()
	{
		spl_autoload_register([$this, 'loadClass']);
	}
}