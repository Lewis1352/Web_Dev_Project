<?php

// Register component on container
$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(
    $container['settings']['view']['template_path'],
    $container['settings']['view']['twig'],
    [
      'debug' => true // This line should enable debug mode
    ]
  );

  // Instantiate and add Slim specific extension
  $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
  $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

  return $view;
};

$container['validator'] = function ($container) {
  $validator = new \Coursework\Validator();
  return $validator;
};

$container['XmlSanitizer'] = function ($container) {
    $validator = new \Coursework\XmlSanitizer();
    return $validator;
};

$container['messageModel'] = function ($container) {
  $model = new \Coursework\MessageModel();
  return $model;
};

$container['databaseWrapper'] = function ($container) {
  $database_wrapper = new \Coursework\DatabaseWrapper();
  return $database_wrapper;
};

$container['sqlQueries'] = function ($container) {
  $sql_queries = new \Coursework\SQLQueries();
  return $sql_queries;
};

$container['SoapClient'] = function ($container) {
    $retrieve_stock_data_model = new \Coursework\soapWrapper();
    return $retrieve_stock_data_model;
};

$container['xmlParser'] = function ($container) {
    $model = new \Coursework\XmlParser();
    return $model;
};