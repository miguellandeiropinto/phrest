<?php
  namespace PhRestClient\Commands;

  use Symfony\Component\Yaml\Yaml;
  use Symfony\Component\Yaml\Exception\ParseException;


  class Config {

    public function set ( $key, $value )
    {
      $config = null;
      try {
          $config = Yaml::parse(file_get_contents('../app.yml'));
      } catch (ParseException $e) {
          printf("Unable to parse the YAML string: %s", $e->getMessage());
      }

      $keys = explode(':', $key);
      $config[$keys[0]][$keys[1]] = $value;
      file_put_contents('../app.yml', Yaml::dump($config));

    }

    public function get ($key)
    {
      $config = null;
      try {
          $config = Yaml::parse(file_get_contents('../app.yml'));
      } catch (ParseException $e) {
          printf("Unable to parse the YAML string: %s", $e->getMessage());
      }
      if ( $config )
      {
        $arr = explode(':', $key);
        echo $key . ' => ' . $config[$arr[0]][$arr[1]];
      }
    }

    public function getEnv ( $name )
    {
      $htaccess = file_get_contents('../.htaccess');
      $htaccess = str_replace("\\t", "", $htaccess);
      $value = null;

      foreach ($lines = explode("\n", $htaccess) as $line )
      {
        if (strpos($line, 'SetEnv ' . $name) !== false )
        {
          $values = explode(" ", $line);
          $value = end($values);
        }
      }
      if ( $value )
      {
        echo sprintf('%s = %s', $name, $value) . PHP_EOL;
        exit();
      }
      echo sprintf("Envoirment variable %s not found.\n", $name);
      exit();
    }

    public function setEnv ( $name, $value )
    {
        $htaccess = file_get_contents('../.htaccess');
        $htaccess = str_replace("\\t", "", $htaccess);
        $lines = explode("\n", $htaccess);
        $htaccess_2 = "";
        $findOpen = false;

        for ( $i = 0; $i < count($lines); $i++ )
        {
          $line = $lines[$i];
          if (strpos($line, '<IfModule mod_env.c>') !== false ) {
              $findOpen = true;

          }

          if ( strpos( $line, 'SetEnv ' . $name ) !== false )
          {
            $line_values = explode(" ", $line);
            $val = end($line_values);
            $lines[$i] = str_replace($val, $value, $line);
            break;
          }

          if ( $findOpen && strpos($line, '</IfModule>') !== false ) {
             $lines[$i - 1] .= "\n    SetEnv " . $name . " " . $value;
          }

        }

        $htaccess_2 .= implode("\n", $lines);
        file_put_contents("../.htaccess", $htaccess_2);
    }

    function deleteEnv ( $name )
    {
        $htaccess = file_get_contents('../.htaccess');
        $htaccess = str_replace("\\t", "", $htaccess);
        $lines = explode("\n", $htaccess);
        $index = null;

        for ( $i = 0; $i < count($lines); $i++) {
          $line = $lines[$i];
          if ( strpos($line, 'SetEnv ' . $name ) !== false )
          {
            $index = $i;
            break;
          }
        }

        if ( $index !== false )
        {
          unset($lines[$index]);
        }

        $htaccess_2 = implode("\n", $lines);
        file_put_contents('../.htaccess', $htaccess_2);

    }

  }
?>
