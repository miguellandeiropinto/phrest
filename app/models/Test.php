<?php

  namespace MyApp\Models;

  use System\Database\Model;

  class Test extends Model
  {

    protected $table = "artists";
    protected $fillable = ['name'];
    protected $xmlNamespace = "myapp";
    protected $xmlRoot = "artist";

  }

?>
