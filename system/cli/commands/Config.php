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

  }
?>
