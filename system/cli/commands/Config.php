<?php
  namespace PhRestClient\Commands;

  use Symfony\Component\Yaml\Yaml;
  use Symfony\Component\Yaml\Exception\ParseException;
  use PhRestClient\Includes\Log;


  class Config {

    public function set ( $key, $value )
    {
      $config = null;
      try {
          $config = Yaml::parse(file_get_contents('../app.yml'));
      } catch (ParseException $e) {
          Log::printlnd("Unable to parse the YAML string.\n" . INFO_MSG . "Check if app.yml file has a valid structure!", ERROR_MSG);
      }

      $keys = explode(':', $key);
      $config[$keys[0]][$keys[1]] = $value;
      file_put_contents('../app.yml', Yaml::dump($config));
      Log::printlnd($keys[0] . ":" .  $keys[1] . " = " . $value );
    }

    public function get ($key)
    {
      $config = null;
      try {
          $config = Yaml::parse(file_get_contents('../app.yml'));
      } catch (ParseException $e) {
          Log::printlnd("Unable to parse the YAML string. Check if app.yml file has a valid structure.");
      }
      if ( $config )
      {
        $arr = explode(':', $key);
        Log::printlnd($key . ' = ' . $config[$arr[0]][$arr[1]]);
      }
    }

    public function getEnv ( $name )
    {
      $htaccess = file_get_contents('../.htaccess');
      $htaccess = str_replace("\\t", "", $htaccess);
      $value = null;

      foreach ($lines = explode("\n", $htaccess) as $line )
      {
        if (strpos($line, 'SetEnv PR_' . $name) !== false )
        {
          $values = explode(" ", $line);
          $value = end($values);
        }
      }
      if ( $value )
      {
        Log::printlnd($name . " = " . $value);
      }
      echo sprintf("Envoirment variable %s not found.\n", $name);
      Log::printlnd("Envoirment variable " . $name . " not found!");

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

          if ( strpos( $line, 'SetEnv PR_' . $name ) !== false )
          {
              $arr = explode(" ", $line );
              if ( count($arr) == 3 ) {
                  unset($arr[2]);
                  $arr[2] = $value;
                  $lines[$i] = implode(" ", $arr);
              } else if (count($arr) == 2 ){
                  $lines[$i] = implode(" ", $arr) . " " . $value;
              }
            break;
          }

          if ( $findOpen && strpos($line, '</IfModule>') !== false ) {
             $lines[$i - 1] .= "\n\tSetEnv PR_" . $name . " " . $value;
          }

        }

        $htaccess_2 .= implode("\n", $lines);
        file_put_contents("../.htaccess", $htaccess_2);
        Log::println("Envoirment variable set successfully. See in .htaccess file.\n\t" . $name . ' = ' . $value);
    }

    function deleteEnv ( $name )
    {
        $htaccess = file_get_contents('../.htaccess');
        $htaccess = str_replace("\\t", "", $htaccess);
        $lines = explode("\n", $htaccess);
        $index = null;

        for ( $i = 0; $i < count($lines); $i++) {
          $line = $lines[$i];
          if ( strpos($line, 'SetEnv PR_' . $name ) !== false )
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
        Log::println("Envoirment variable " . $name . " deleted succesffuly!");
    }

  }
?>
