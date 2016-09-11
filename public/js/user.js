$(document).ready(function() {

    $("#login-nav").submit(function(event)
    {
        event.preventDefault();

        var postData = $(this).serializeArray();
        var ajaxLoginURL  = '/login/ajax';

        $.ajax(
        {
            url : ajaxLoginURL,
            type: "POST",
            data : postData,
            dataType: 'json',
            success:function(data, textStatus, jqXHR)
            {
                if (data.status == 0)
                {
                    for (var msg in data.message)
                    {
                        $.bootstrapGrowl(data.message[msg], { type: 'danger' });
                    }

                } else {
                    location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                $.bootstrapGrowl("Oopsie, something when wrong.", { type: 'danger' });
            }
        });

    });

    $("#btn-logout").click(function(event)
    {
        event.preventDefault();

        var ajaxLogoutURL  = '/logout/ajax';

        $.ajax(
        {
            url : ajaxLogoutURL,
            type: "GET",
            dataType: 'json',
            success:function(data, textStatus, jqXHR)
            {
                if (data.status == 1)
                {
                    location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                $.bootstrapGrowl("Oopsie, something when wrong.", { type: 'danger' });
            }
        });

    });

});
