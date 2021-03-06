<?php
@include('init.php');
include('universal_functions.php');
$allowed = "pages";
include('security_checks.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Page Registration Intro</title>
        <?php include('required_header.php'); ?>
        <script type="text/javascript">
            function change_color()
            {
                <?php
                    if (isset($_SESSION['id']))
                    {
                        $colors = get_user_display_colors($_SESSION['id']);
                        $color = $colors[0];
                        $box_background_color = $colors[1];
                        $text_color = $colors[2];
                    }
                    else
                    {
                        $color = "rgb(220,20,0)";
                        $box_background_color = "white";
                        $text_color = "rgb(30,30,30)";
                    }
                ?>
                $('.box').css('border', '5px solid <?php echo $color; ?>');
                $('.box').css({'background-color': '<?php echo $box_background_color; ?>'});


                $('.title_color').css('color', '<?php echo $color; ?>');
                $('.text_color').css('color', '<?php echo $text_color; ?>');
            }

            $(document).ready(function()
            {
                <?php include('required_jquery.php'); ?>
            });
        </script>
        <script type="text/javascript">
            <?php include('required_google_analytics.js'); ?>
        </script>
    </head>
    <body>
        <?php include('required_html.php'); ?>
        <div id="top">
        <?php include('page_top.php'); ?>
        </div>
        <div id="main">
            <div id="page_registration_intro_content" class="content box">
                
            </div>
            <?php include('footer.php'); ?>
        </div>
    </body>
</html>