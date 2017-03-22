<?php

namespace MyApp\Models;

use System\Database\Model;

class Test extends Model
{

    protected $table = "artists";
    protected $fillable = ['name'];
    protected $xmlNamespace = "a";
    protected $xmlRoot = "artist";
    protected $collectionXmlRoot = "artists";


    function albuns()
    {
        return $this->belongsToMany('MyApp\Models\Album', 'album_artists', 'id_artist', 'id_album');
    }

}

?>
