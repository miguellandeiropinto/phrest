<?php

namespace System;

use System\Http\Response;

class View
{
    public function render($response)
    {
        $response->_setHeaders();
        $data = $response->data;
        echo $data;
        return true;

    }
}


?>
