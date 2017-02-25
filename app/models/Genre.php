<?php

  namespace MyApp\Models;

  use Illuminate\Database\Eloquent\Model as Eloquent;

  class Genre extends Eloquent {

    protected $table = "genres";
    protected $fillable = ['name'];

  }

?>
