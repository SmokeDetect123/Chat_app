$(document).ready(function() {
    $('#signout').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: "logout.php",
            method: "POST",
            dataType: "json",
            success: function(data) {
                if (data.message) {
                    alert('Successfully Logout');
                    window.location = 'index.php';
                }
            }
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
});
