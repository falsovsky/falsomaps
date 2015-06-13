$( document ).ready(function() {
    $("#login-nav").submit(function(e)
    {
        var postData = $(this).serializeArray();
        var formURL  = '/login/ajax';

        $.ajax(
        {
            url : formURL,
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
                $.bootstrapGrowl("Oopsie, something when wrong submiting.", { type: 'danger' });
            }
        });
        e.preventDefault();
    });
});

