<?php
    $templateURI = get_template_directory_uri();
    $siteTitle = get_bloginfo("name");
?>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- /!\/!\/!\ attention à enlever lors de la mise en ligne -->
    <meta name="robots" content="noindex" />

    <title><?php echo($siteTitle) ?></title>

    <!-- Custom fonts for this template -->
    <link
      href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
      rel="stylesheet"
      type="text/css"
    />

    <?php
      echo('
        <link href="' . $templateURI . '/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="' . $templateURI . '/css/one-page-wonder.css" rel="stylesheet"/>
        <link href="' . $templateURI . '/css/custom.css" rel="stylesheet"/>
      ');
    ?>

    <!--
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-35729023-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
    -->

  </head>
