
<?php



$app->get(    '/book',      '_book');
$app->get(    '/application',      '_application');
$app->get(    '/application/toolbar',      '_toolbar');
$app->get(    '/application/editor',      '_editor');
$app->get(    '/application/pages',      '_pages');

function _pages()  { 

      $app = Slim::getInstance();

        $data = array();

        
        $app->render('pages.html', $data);


}



function _book()  { 

      $app = Slim::getInstance();

        $data = array();

        
        $app->render('application/book.html', $data);


}


function _application()  { 

      $app = Slim::getInstance();

        $data = array();

        
        $app->render('application/application.html', $data);


}

function _toolbar()  { 

      $app = Slim::getInstance();

        $data = array();

        
        $app->render('application/toolbar.html', $data);


}

function _editor()  { 

      $app = Slim::getInstance();

        $data = array();
        $data["pagecont"] = file_get_contents("/book");

        
        $app->render('application/editor.html', $data);


}