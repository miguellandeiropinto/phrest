<?php

  namespace PhRestClient\Commands;

  use PhRestClient\Includes\Template;

  class Model extends Template {

    public function create ( $data = null )
    {

      if ( !$data && count($data) != 2) return false;

      Template::run(
        __DIR__ . '/../includes/templates/ModelTemplate.txt',
        __DIR__ . '/../../..'. APPMODELS_PATH . $data['class_name'] . '.php',
        [
          '{namespace}' => $data['namespace'],
          '{class_name}' => $data['class_name'],
          '{table}' => $data['table'] ? $data['table'] : '',
          '{fillable}' => $data['fillable'] ? $data['fillable'] : '[]'
        ]
      );

    }

  }

?>
