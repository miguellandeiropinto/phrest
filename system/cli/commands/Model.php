<?php

namespace PhRestClient\Commands;

use PhRestClient\Includes\Template;

class Model extends Template
{

    public function create($data = null)
    {

        if (!$data && count($data) != 2)
            \PhRestClient\Includes\Log::printlnd("Missing parameters!", ERROR_MSG);

        Template::run(
            __DIR__ . '/../includes/templates/ModelTemplate.txt',
            __DIR__ . '/../../..' . APPMODELS_PATH . '/' . $data['class_name'] . '.php',
            [
                '{namespace}' => $data['namespace'],
                '{class_name}' => $data['class_name'],
                '{table}' => $data['table'] ? $data['table'] : '',
                '{fillable}' => $data['fillable'] ? $data['fillable'] : '[]',
                '{xmlRoot}' => $data['xmlRoot'] ? $data['xmlRoot'] : '',
                '{xmlNamespace}' => $data['xmlNamespace'] ? $data['xmlNamespace'] : '',
                '{collectionXmlRoot}' => $data['collectionXmlRoot'] ? $data['collectionXmlRoot'] : ''
            ]
        );

    }

}

?>
