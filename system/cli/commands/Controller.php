<?php
namespace PhRestClient\Commands;
use PhRestClient\Includes\Template;

class Controller extends Template
{

    public function create($data = null)
    {

        if (!$data && count($data) != 2) return false;

        Template::run(
            __DIR__ . '/../includes/templates/ControllerTemplate.txt',
            __DIR__ . '/../../..' . APPCTRL_PATH . $data['class_name'] . '.php',
            [
                '{namespace}' => $data['namespace'],
                '{class_name}' => $data['class_name']
            ]
        );

    }

}

?>
