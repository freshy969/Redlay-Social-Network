<div class='header_background'></div>
<a href="http://www.redlay.com" id="icon_link"><img id="icon" src="http://pics.redlay.com/pictures/redlay_title.png"/></a>
        <input id="search_box_submit_button" name="search_box_submit_button" class="button" type="button" value="Search" onClick="search();" />
<input type="button" id="menu_button" value="Places" class="button" onClick="display_map();" onmouseover="{display_title(this, 'Go anywhere!');}" onmouseout="{hide_title(this);}"/>

<a class="link" href="http://www.redlay.com/page.php?page_id=<?php echo $_SESSION['page_id']; ?>"><input type="button" class="button" id="profile_button" value="Page" /></a>
<div id="alerts">
    <table>
        <tbody>
            <tr>
                <td>
                    <p id="messages_alert_numbers" class="alert_numbers" style="height:20px;"><?php if(has_messages_alerts_page())echo "(".get_messages_alerts_page().")"; ?></p>
                </td>
                <td>
                    <p id="alert_alert_numbers" class="alert_numbers" style="height:20px;"><?php if(has_alert_alerts_page()=='true')echo "(".get_alert_alerts_page().")"; ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <a class="link" href="http://www.redlay.com/page_messages.php" ><img id="messages_alert" src="http://pics.redlay.com/pictures/messages_alert.png" alt="Photo unavailable" onmouseover="{this.src='http://pics.redlay.com/pictures/messages_alert_over.png'; display_title(this, 'Messages');}" onmouseout="{this.src='http://pics.redlay.com/pictures/messages_alert.png'; hide_title(this);}"/></a>
                </td>
                <td>
                    <a class="link" href="http://www.redlay.com/page_alerts.php" ><img id="alert_alert" src="http://pics.redlay.com/pictures/alert.png" alt="Photo unavailable" onmouseover="{this.src='http://pics.redlay.com/pictures/alert_over.png'; display_title(this, 'Alerts');}" onmouseout="{this.src='http://pics.redlay.com/pictures/alert.png'; hide_title(this);}"/></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!--<a class="link" href="http://www.redlay.com/home.php"><input class="button" id="homeButton" type="button" value="Home" /></a>-->
<div id="top_map">
    <div id="map_top_slots">

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#top_map').hide();
        display_top_grid_slots();
        display_top_grid();
        <?php if($_SERVER['REQUEST_URI']!='/registration_intro.php') echo "alert_time_events();"; ?>
    });
    function display_map()
    {
        if($('#top_map').css('display')=='none')
        {
            $('#top_map').show();
            $('#top_map').stop().animate(
            {
                height:'350px', 
                width: '650px', 
                left: '250px'
            }, 400, function()
            {});
        }
        else
        {
            $('#top_map').stop().animate(
            {
                height:'0px',
                width: '0px',
                left: '900px'
            }, 300, function()
            {
                $('#top_map').hide();
            });
        }
    }

    function alert_time_events()
    {
        //display_messaged_users();
        online();
        check_alerts();
        setInterval(function()
        {
            check_alerts();
        }, 5000);
    }
    function check_alerts()
    {
        $.post('alert_query.php',
        {

        }, function(output)
        {
            var new_friends=output.new_friends;
            var new_messages=output.new_messages;
            var new_message_id=output.new_message_id;
            var new_alerts=output.new_alerts;
            
            $('body').attr('onmouseover', '');

            var total=0;
            if(new_friends!=0)
            {
                $('#friend_request_alert_numbers').html("("+new_friends+')');
                total+=parseInt(new_friends);
                
                <?php 
                    if($_SERVER['REQUEST_URI']=='/home.php')
                        echo "document.title='Home ('+total+')';";
                    else if(strpos($_SERVER["SERVER_NAME"],'profile.php')==true)
                        echo "document.title='Redlay ('+total+')';";
                ?>
            }
            else
                $('#friend_request_alert_numbers').html("");
            
            if(new_messages!=0)
            {
                $('#messages_alert_numbers').html("("+new_messages+')');
                total+=parseInt(new_messages);
                if(new_messages==1)
                    document.title=new_messages+' new message';
                else
                    document.title=new_messages+' new messages';
                
                <?php 
                    if($_SERVER['REQUEST_URI']=='/messages.php')
                        echo "display_messages(new_message_id, 1);";
                ?>
            }
            else
            {
                $('#messages_alert_numbers').html("");
                <?php 
                    if($_SERVER['REQUEST_URI']=='/messages.php')
                        echo "$('body').attr('onmouseover', 'reset_message_title();');";
                ?>
            }
            
            if(new_alerts!=0)
            {
                $('#alert_alert_numbers').html("("+new_alerts+')');
                total+=parseInt(new_alerts);
                
                <?php 
                    if($_SERVER['REQUEST_URI']=='/home.php')
                        echo "document.title='Home ('+total+')';";
                    else if(strpos($_SERVER["SERVER_NAME"],'profile.php')==true)
                        echo "document.title='Redlay ('+total+')';";
                ?>
            }
            else
                $('#alert_alert_numbers').html("");
            
            
        }, "json");
    }
    
    function reset_message_title()
    {
        document.title="Messages";
    }


    //displays the slots for grid
    function display_top_grid_slots()
    {
        //clears contents for reload or startup
        $('#map_top_slots').html('');

        //displays slots of map is grid
        var index=0;
        $('#map_top_slots').html("<table id='map_top_table'></table>");
        for(var x = 0; x < 3; x++)
        {
            $('#map_top_table').html($('#map_top_table').html()+"<tr class='map_top_slot_row' id='map_top_slot_row_"+x+"'></tr>");
            for(var y = 0; y < 6; y++)
            {
                $('#map_top_slot_row_'+x).html($('#map_top_slot_row_'+x).html()+"<td id='map_top_item_slot_"+index+"' class='map_top_item_slot' ></td>");
                index++;
            }
        }
        $('#map_top_slots').html($('#map_top_slots').html()+"<input type='button' id='edit_map_top_button' class='red_button' value='Edit Map' />");
        $('#edit_map_top_button').attr({'onmouseover': "red_button_over('#edit_map_top_button');", 'onmouseout': "red_button_out('#edit_map_top_button');", 'onClick': "window.location.replace('http://www.redlay.com/map.php');"});
    }
    //displays regular default map_items without modification
    function display_top_grid()
    {
        $.post('map_query.php',
        {
            num: 2
        }, function(output)
        {
            var default_items=output.default_items;
            var default_position_grid=output.default_position_grid;
            var links=output.links;

            for(var x =0; x < default_items.length; x++)
            {
                $('#map_top_item_slot_'+default_position_grid[x]).html("<a class='link' href='http://www.redlay.com/"+links[x]+"'><div class='map_top_item' id='map_top_grid_item_"+default_position_grid[x]+"'  ></div></a>");
                    $('#map_top_grid_item_'+default_position_grid[x]).attr({'onmouseover': "display_title(this, '"+default_items[x]+"');", 'onmouseout': "hide_title(this);"});
                    $('#map_top_item_slot_'+default_position_grid[x]).attr({'onmouseover': "$(this).css({'border-color': 'rgb(220,21,0)', 'cursor': 'pointer'});$(this).css({'background-color': 'white', 'box-shadow': 'inset 0px 0px 10px black'});", 'onmouseout': "$(this).css({'border-color': 'gray', 'cursor': 'default'});$(this).css({'background-color': '', 'box-shadow': ''});"});

                $('#map_top_grid_item_'+default_position_grid[x]).html("<div id='map_top_item_hidden_"+default_position_grid[x]+"' class='map_top_hidden_layer' ></div>");
                $('#map_top_item_hidden_'+default_position_grid[x]).attr({'onmouseover': "map_item_over('#map_top_grid_item_"+default_position_grid[x]+"');", 'onmouseout': "map_item_out('#map_top_grid_item_"+default_position_grid[x]+"');"});
                $('#map_top_grid_item_'+default_position_grid[x]).html($('#map_top_grid_item_'+default_position_grid[x]).html()+"<img src='http://pics.redlay.com/pictures/"+default_items[x]+".png' class='map_item_picture' id='map_top_item_image_"+default_position_grid[x]+"' />");

                //adds the item's title
                $('#map_top_grid_item_'+default_position_grid[x]).html($('#map_top_grid_item_'+default_position_grid[x]).html()+"<br class='map_top_break' />");
            }
            display_added_top_grid();
            change_color();
        }, "json");
    }
    
    //displays the user_added map items
    function display_added_top_grid()
    {
        $.post('map_query.php',
        {
            num: 3
        }, function(output)
        {
            var added_items=output.added_items;
            var added_position_grid=output.added_item_positions;
            var links=output.links;
            var types=output.types;
            var profile_pictures=output.profile_pictures;
            var added_item_names=output.names;

            for(var x =0; x < added_items.length; x++)
            {
                if(types[x]!='')
                    var link="window.location.replace('http://www.redlay.com/"+links[x]+"');";
                else
                    var link="window.open('"+added_item_names[x]+"');";
                $('#map_top_item_slot_'+added_position_grid[x]).html("<div class='map_top_item' id='map_top_grid_item_"+added_position_grid[x]+"' onClick="+link+"></div>");
                    $('#map_top_grid_item_'+added_position_grid[x]).attr({'onmouseover': "display_title(this, '"+added_item_names[x]+"');", 'onmouseout': "hide_title(this);"});
                    $('#map_top_item_slot_'+added_position_grid[x]).attr({'onmouseover': "$(this).css({'border-color': 'rgb(220,21,0)', 'cursor': 'pointer'});", 'onmouseout': "$(this).css({'border-color': 'gray', 'cursor': 'default'});"});

                $('#map_top_grid_item_'+added_position_grid[x]).html("<div id='map_top_item_hidden_"+added_position_grid[x]+"' class='map_top_hidden_layer' ></div>");
                $('#map_top_item_hidden_'+added_position_grid[x]).attr({'onmouseover': "map_item_over('#map_top_grid_item_"+added_position_grid[x]+"');", 'onmouseout': "map_item_out('#map_top_grid_item_"+added_position_grid[x]+"');"});
                $('#map_top_grid_item_'+added_position_grid[x]).html($('#map_top_grid_item_'+added_position_grid[x]).html()+"<img src='"+profile_pictures[x]+"' id='map_top_item_image_"+added_position_grid[x]+"' class='map_top_item_image' />");

                //adds the item's title
                $('#map_top_grid_item_'+added_position_grid[x]).html($('#map_top_grid_item_'+added_position_grid[x]).html()+"<br class='map_top_break' />");
            }
            change_color();
        }, "json");
    }

    
    function javascript_time_event()
    {
        var currentTime=new Date();
        setTimeout(function()
        {
            if(currentTime.getSeconds()==58)
                animate_redlay_logo();
            javascript_time_event();
        }, 1000);
    }

    //animates redlay logo to look like a wave of red
    function animate_redlay_logo()
    {
        $('#icon').hide();
        $('#icon_link').html("<p id='icon'></p>");
        $('#icon').html("<span id='temp_redlay_r' class='text'>r</span>");
        $('#icon').html($('#icon').html()+"<span id='temp_redlay_e' class='text'>e</span>");
        $('#icon').html($('#icon').html()+"<span id='temp_redlay_d' class='text'>d</span>");
        $('#icon').html($('#icon').html()+"<span id='temp_redlay_l' class='text'>l</span>");
        $('#icon').html($('#icon').html()+"<span id='temp_redlay_a' class='text'>a</span>");
        $('#icon').html($('#icon').html()+"<span id='temp_redlay_y' class='text'>y</span>");
        
        var speed=150;

        $('#temp_redlay_r').animate({opacity:.2}, speed, function()
        {
            $('#temp_redlay_e').animate({opacity:.2}, speed, function()
            {
                $('#temp_redlay_d').animate({opacity:.2}, speed, function()
                {
                    $('#temp_redlay_l').animate({opacity:.2}, speed, function()
                    {
                        $('#temp_redlay_a').animate({opacity:.2}, speed, function()
                        {
                            $('#temp_redlay_y').animate({opacity:.2}, speed, function()
                            {});
                        });
                    });
                });
                $('#temp_redlay_r').animate({opacity:1}, speed, function()
                {
                    $('#temp_redlay_e').animate({opacity:1}, speed, function()
                    {
                        $('#temp_redlay_d').animate({opacity:1}, speed, function()
                        {
                            $('#temp_redlay_l').animate({opacity:1}, speed, function()
                            {
                                $('#temp_redlay_r').animate({opacity:.2}, speed, function()
                                {
                                    $('#temp_redlay_e').animate({opacity:.2}, speed, function()
                                    {
                                        $('#temp_redlay_d').animate({opacity:.2}, speed, function()
                                        {
                                            $('#temp_redlay_l').animate({opacity:.2,marginTop: '0px'}, speed, function()
                                            {
                                                $('#temp_redlay_a').animate({opacity:.2,marginTop: '0px'}, speed, function()
                                                {
                                                    $('#temp_redlay_y').animate({opacity:.2,marginTop: '0px'}, speed, function()
                                                    {

                                                    });
                                                });
                                            });
                                        });
                                        $('#temp_redlay_r').animate({opacity:1}, speed, function()
                                        {
                                            $('#temp_redlay_r').animate({opacity:1}, speed, function()
                                            {
                                                $('#temp_redlay_e').animate({opacity:1}, speed, function()
                                                {
                                                    $('#temp_redlay_d').animate({opacity:1}, speed, function()
                                                    {
                                                        $('#temp_redlay_l').animate({opacity:1}, speed, function()
                                                        {
                                                            $('#temp_redlay_a').animate({opacity:1}, speed, function()
                                                            {
                                                                $('#temp_redlay_y').animate({opacity:1}, speed, function()
                                                                {});
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                                $('#temp_redlay_a').animate({opacity:1}, speed, function()
                                {
                                    $('#temp_redlay_y').animate({opacity:1}, speed, function()
                                    {});
                                });
                            });
                        });
                    });
                });
            });
        });
    }
    function search()
    {
        window.location.replace('http://www.redlay.com/search.php');
    }
</script>