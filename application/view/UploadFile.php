<!--<html>-->
<!---->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<!--    <title></title>-->
<!--    <meta name="description" content="">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>-->
<!--    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>-->
<!--    <link rel="stylesheet" href="--><?php //$this->asset('css/bootstrap.min.css') ?><!--">-->
<!--    <link rel="stylesheet" href="--><?php //$this->asset('css/unicons.css') ?><!--">-->
<!--    <link rel="stylesheet" href="--><?php //$this->asset('css/owl.carousel.min.css') ?><!--">-->
<!--    <link rel="stylesheet" href="--><?php //$this->asset('css/owl.theme.default.min.css') ?><!--">-->
<!---->
<!--    <!-- MAIN STYLE -->-->
<!--    <link rel="stylesheet" href="--><?php //$this->asset('css/tooplate-style.css') ?><!--">-->
<!--</head>-->
<!---->
<!--<body>-->
<!--<form data-validation="true" action="--><?php //$this->url('upload/uploadFile'); ?><!--" method="post" id="upload_form"-->
<!--      enctype="multipart/form-data">-->
<!--    <div class="item-inner">-->
<!--        <div class="item-content">-->
<!--            <div class="image-upload">-->
<!--                <label style="cursor: pointer;" for="file_upload"> <img src="" alt="" class="uploaded-image">-->
<!--                    <div class="h-100">-->
<!--                        <div class="dplay-tbl">-->
<!--                            <div class="dplay-tbl-cell">-->
<!--                                <img src="--><?php //$this->asset('images/icons8-plus-math-48.png') ?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <input data-required="image" type="file" name="file[]" id="file_upload" class="image-input"-->
<!--                           data-traget-resolution="image_resolution" value="" multiple>-->
<!--                </label>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</form>-->
<!---->
<!--<script>-->
<!--    document.getElementById("file").onchange = function () {-->
<!--        document.getElementById("form").submit();-->
<!--    };-->
<!--</script>-->
<!---->
<!--<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>-->
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>-->
<!--</body>-->
<!---->
<!--</html>-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<form method='post' action='<?php $this->url('upload/uploadFile'); ?>' enctype='multipart/form-data'>

    <input type="file" name="file[]" id="file" multiple>
    <input type='submit' name='submit' value='Upload'>

</form>
</body>

</html>