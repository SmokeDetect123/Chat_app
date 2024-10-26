<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styledashboard.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="outerbox">
        <div id="inner1">
            <div id="sidebar1">
                <div id="sideimagelogobox">
                    <!-- Logo or Image -->
                </div>
            </div>
            <div id="sidebar2">
                <div id="sideulbox">
                    <ul>
                        <li id="active"><a href="dashboard.php"><i class="fa fa-comments fa-1x" aria-hidden="true"></i></a></li>
                        <li><a href="friend.php"><i class="fa fa-users fa-1x" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div id="sidebar3">
                <a href="javascript:void(0)"><i class="fa fa-sign-out fa-1x" aria-hidden="true" id="signout"></i></a>
            </div>
        </div>
        <div id="inner2">
            <div id="inner2searchbox">
                <input type="text" name="" placeholder="Enter a search here" onkeyup="myFunction()" id="myInput1">
            </div>
            <div id="inner2containerbox">
                <ul id="inner2containerboxul">
                    <!-- User list will be dynamically populated here -->
                </ul>
            </div>
        </div>
        <div id="inner3">
            <div id="inner3container">
                <!-- Chat messages will be dynamically populated here -->
            </div>
            <div id="inner3footer">
                <div id="inner3searchbox">
                    <input type="textarea" id="text_message" placeholder="Type message">
                    <i class="fa fa-paper-plane fa-1x" aria-hidden="true" onclick="send_message()"></i>
                </div>
            </div>
        </div>
        <div id="inner4">
            <div id="inner4section1">
                <div id="inner4imageprofilebox">
                    <img src="design.jpg">
                </div>
            </div>
            <div id="inner4section2">
                <div id="inner4section2section1">
                    <ul>
                        <li>
                            <h2 id="getuserdetails_user_name"></h2>
                        </li>
                        <li>
                            <h4 id="getuserdetails_total_friend"></h4>
                        </li>
                    </ul>
                </div>
                <div id="inner4section2section2">
                    <ul>
                        <li>
                            <span>
                                <i class="fa fa-user fa-1x" aria-hidden="true"></i>
                            </span>
                            <h4 id="getuserdetails_fullname"></h4>
                        </li>
                        <li>
                            <span>
                                <i class="fa fa-map-marker fa-1x" aria-hidden="true"></i>
                            </span>
                            <h4 id="getuserdetails_location"></h4>
                        </li>
                        <li>
                            <span>
                                <i class="fa fa-envelope-o fa-1x" aria-hidden="true"></i>
                            </span>
                            <h4 id="getuserdetails_user_email"></h4>
                        </li>
                        <li>
                            <span>
                                <i class="fa fa-phone fa-1x" aria-hidden="true"></i>
                            </span>
                            <h4 id="getuserdetails_user_contactnumber"></h4>
                        </li>
                        <li>
                            <span>
                                <i class="fa fa-birthday-cake fa-1x" aria-hidden="true"></i>
                            </span>
                            <h4 id="getuserdetails_date_of_birth"></h4>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#signout').on('click', function(event){
                event.preventDefault();
                $.ajax({
                    url: "logout.php",
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data.message) {
                            alert('Successfully Logout');
                            window.location = 'index.php';
                        }
                    }
                });
            });
        });

        function loadMessages() {
            $.ajax({
                url: 'chat.php',
                method: 'GET',
                dataType: 'xml',
                success: function(xml) {
                    $('#inner3container').empty();
                    $(xml).find('message').each(function() {
                        var user = $(this).find('user').text();
                        var text = $(this).find('text').text();
                        $('#inner3container').append('<div class="chat-message"><strong>' + user + ':</strong> ' + text + '</div>');
                    });
                    $('#inner3container').scrollTop($('#inner3container')[0].scrollHeight);
                }
            });
        }

        function sendMessage() {
            var message = $('#text_message').val();
            if (message.trim() !== '') {
                $.ajax({
                    url: 'chat.php',
                    method: 'POST',
                    data: { message: message },
                    success: function() {
                        $('#text_message').val('');
                        loadMessages();
                    }
                });
            }
        }

        $('#text_message').keypress(function(e) {
            if (e.which == 13) {
                sendMessage();
                return false;
            }
        });

        setInterval(loadMessages, 2000);
        loadMessages();
    </script>
</body>
</html>