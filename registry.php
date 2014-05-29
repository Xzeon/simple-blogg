<?php

spl_autoload_register(function($className) {
    $paths = [
        'libs/',
        'models/',
        'controllers/',
    ];

    foreach ($paths as $path) {
        $path = $path . $className . '.php';
        if (file_exists($path)) {
            require_once "$path";
        }
    }
});

/**
 * Register classes and their dependencies with IoC::register. The IoC class then holds a reference to all 
 * the registered classes with lambda functions. When called with IoC::resolve, the target class is created with
 * all dependencies injected.
 */

IoC::register('FrontController', function(){
	$db = new Database();
	$fc = new FrontController(new DatabaseGateway($db), new View, new Route(new DatabaseGateway($db))); 
	return $fc;
});

IoC::register('RegisterController', function(){
	$db = new Database();
	$rc = new RegisterController(new DatabaseGateway($db), new View, new inputHandler, new inputValidation, new Authentication);
	return $rc;
});

IoC::register('SetupController', function(){
	$db = new Database();
	$sc = new SetupController(new DatabaseGateway($db), new View, new InputHandler, new InputValidation);
	return $sc;
});

IoC::register('LoginController', function(){
	$db = new Database();
	$lc = new LoginController(new DatabaseGateway($db), new View, new InputHandler, new InputValidation, new Authentication);
	return $lc;
});


IoC::register('PostController', function(){
	$db = new Database();
	$pc = new PostController(new DatabaseGateway($db), new View, new OutputFiltering);
	return $pc;
});


IoC::register('CreateController', function(){
	$db = new Database();
	$ac = new CreateController(new DatabaseGateway($db), new View, new InputHandler, new InputValidation, new InputFiltering);
	return $ac;
});


IoC::register('SinglePostController', function(){
	$db = new Database();
	$spc = new SinglePostController(new DatabaseGateway($db), new View, new InputHandler, new InputValidation, new InputFiltering, new OutputFiltering);
	return $spc;
});

IoC::register('ConfigController', function(){
	$db = new Database();
	$cc = new ConfigController(new DatabaseGateway($db), new View, new inputHandler, new inputValidation, new inputFiltering);
	return $cc;
});

IoC::register('DeleteController', function(){
	$db = new Database();
	$dc = new DeleteController(new DatabaseGateway($db));
	return $dc;
});

IoC::register('EditController', function(){
	$db = new Database();
	$ec = new EditController(new DatabaseGateway($db), new View, new InputHandler, new InputValidation, new InputFiltering);
	return $ec;
});
