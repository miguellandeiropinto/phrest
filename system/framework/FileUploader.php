
<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" multiple="multiple">
    <input type="submit" value="Upload">
  </form>
  <script>

    $(function (){

      $('form input[type="file"]').on('change', function () {
        alert('changed');
        console.log($(this)[0].files);
      });
    })

  </script>
</body>
</html>
<?php

  class FileUploader
  {

    function upload ()
    {

      var_dump($_FILES);

    }

    function uploadFile ()
    {

    }

  }

  FileUploader::upload();
?>
