<?php
@include('init.php');
if(!isset($_SESSION['id']))
{
    header("Location: http://m.redlay.com/index.php");
    exit();
}
$query=strip_tags(stripslashes(mysql_real_escape_string($_GET['query'])));
?>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="mobile_main.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Chivo' rel='stylesheet' type='text/css' />
        <script type="text/javascript" src="all_jQuery.js"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $('#menu').hide();
                $('body').css({'background-color': 'rgb(10,10,10)'});
                $('.box').css({'border-width': '5%', 'border-style': 'solid', 'border-color': 'rgb(220,21,0)', 'background-color': "white"});
            });
            $(document).ready(function()
            {
                $.post('search_query.php',
                {
                    query: '<?php echo $query; ?>'
                }, function(output)
                {
                    var results=output.results;
                    var result_names=output.result_names;
                    var profile_image=output.profile_images;

                    for(var x = 0; x < results.length; x++)
                    {
                        var div="<div id='result_"+x+"' class='result'></div>";
                        $('#search_results').html($('#search_results').html()+div);
                    }
                    for(var x = 0; x < results.length; x++)
                    {
                        if(results[x]!=0)
                        {
                            var name="<div class='user_name_body'><a class='result_name_link' href='http://m.redlay.com/profile.php?user_id="+results[x]+"'><p class='search_result_name' id='search_result_name_"+x+"'>"+result_names[x]+"</p></a></div>";
                            var image="<div class='profile_picture_body'><a href='http://m.redlay.com/profile.php?user_id="+results[x]+"'><img src='"+profile_image[x]+"' class='search_profile_picture profile_picture' id='search_profile_picture_"+x+"' /></a></div>";
                            $("#result_"+x).html(name+image);
                        }
                    }
                    //displays the page results
                    if(results.length==0)
                        $('#search_results').html("No matches found");

                    $('.search_result_name').css('color', 'rgb(220,21,0)');
                }, "json");
            });
        </script>
    </head>
    <body>
        <?php include('top.php'); ?>
        <div id="main">
            <div id="content" class="box">
                <div id="search_results">

                </div>
            </div>
        </div>
    </body>
</html>
