<?php

  namespace PhRestClient\Includes;

  class Template
  {

    function run ( $template_name = null, $output_path = null , $data = array() )
    {
      $content = file_get_contents( $template_name );
      foreach ( $data as $key => $value )
      {
        $content = str_replace($key, $value, $content);
      }

      file_put_contents($output_path, $content);
    }

  }

?>
