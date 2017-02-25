<?php

  namespace System;
  use App\Controllers;

  class App {

    public $request;

    public function __construct () {
      $this->request = new Request();
      $this->appControllers = $this->getAppControllersAndModelsInfo()['controllers'];
      $this->appModels = $this->getAppControllersAndModelsInfo()['models'];
    }

    public function run () {

      if ( array_key_exists($this->request->getEntity(), $this->appControllers) )
      {
        
        if ( class_exists(CTRLS_NS . "\\" . ucfirst($this->request->getEntity()).'Controller') )
        {
          $entityConstructor = CTRLS_NS . "\\" . ucfirst($this->request->getEntity()).'Controller';
          $entity = new $entityConstructor();

          if ( method_exists($entity, $this->request->getMethod()) )
          {
            $method = $this->request->getMethod();
            $entity->$method($this->request, new Response());
          } else {
            echo $this->request->getEntity();
          }
        } else {
            $this->request->getEntity();
        }
      }

    }

    public function getAppControllersAndModelsInfo () {

      $info = array(
        'controllers' => array(),
        'models' => array()
      );
      $dirCtrls = new \DirectoryIterator(__DIR__ . '/../..' . rtrim(CTRLS_PATH, '/'));
      foreach ($dirCtrls as $file) {
          if (!$file->isDot()) {
              $info['controllers'][strtolower(str_replace( 'Controller.php', '', $file->getFilename() ))] = CTRLS_PATH . $file->getFilename();
          }
      }

      $dirModels = new \DirectoryIterator(__DIR__ . '/../..' . rtrim(MODELS_PATH, '/'));
      foreach ($dirModels as $file) {
          if (!$file->isDot()) {
              $info['models'][strtolower(str_replace( 'Model.php', '', $file->getFilename() ))] = MODELS_PATH . $file->getFilename();
          }
      }

      return $info;

    }

  }

?>
