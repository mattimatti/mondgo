<?php


$app->get(    '/:db/:collection',      '_list');
$app->post(   '/:db/:collection',      '_create');
$app->get(    '/:db/:collection/:id',  '_read');
$app->put(    '/:db/:collection/:id',  '_update');
$app->delete( '/:db/:collection/:id',  '_delete');

// List

function _list($db, $collection){
  
  $select = array(
    'limit' =>    (isset($_GET['limit']))   ? $_GET['limit'] : false, 
    'page' =>     (isset($_GET['page']))    ? $_GET['page'] : false,
    'filter' =>   (isset($_GET['filter']))  ? $_GET['filter'] : false,
    'regex' =>    (isset($_GET['regex']))   ? $_GET['regex'] : false,
    'sort' =>     (isset($_GET['sort']))    ? $_GET['sort'] : false
  );
  
  $data = mongoList(
    MONGO_HOST, 
    $db, 
    $collection,
    $select
  );
  echo json_encode($data);

}

// Create

function _create($db, $collection){

  $document = json_decode(Slim::getInstance()->request()->getBody(), true);

  $data = mongoCreate(
    MONGO_HOST, 
    $db, 
    $collection, 
    $document
  ); 
  echo json_encode($data);
  
}

// Read

function _read($db, $collection, $id){

  $data = mongoRead(
    MONGO_HOST,
    $db,
    $collection,
    $id
  );
  echo json_encode($data);

}

// Update 

function _update($db, $collection, $id){

  $document = json_decode(Slim::getInstance()->request()->getBody(), true);

  $data = mongoUpdate(
    MONGO_HOST, 
    $db, 
    $collection, 
    $id,
    $document
  ); 
  echo json_encode($data);
  
}

// Delete

function _delete($db, $collection, $id){

  $data = mongoDelete(
    MONGO_HOST, 
    $db, 
    $collection, 
    $id
  ); 
  echo json_encode($data);

}