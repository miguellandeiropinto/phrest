<?php

  namespace MyApp\Models;

  use Illuminate\Database\Eloquent\Model as Eloquent;

  class Artist extends Eloquent {

    protected $table = "artists";
    protected $fillable = ['name'];

  }

?>
