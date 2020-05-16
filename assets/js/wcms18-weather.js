(function($){

    //console.log("My AJAX URL is", my_ajax_obj.ajax_url)

    $(document).ready(function(){
        $('.widget_wcms18-weather-widget').each(function(i, widget) {
            var current_weather = $(widget).find('.current-weather'),
            widget_city = $(current_weather).data('city'),
            widget_country = $(current_weather).data('country');

            $.post(
                    wcms18_weather_settings.ajax_url, //url
                    {
                        action: 'get_current_weather',
                        city: widget_city,
                        country: widget_country,
                    } //data send to server
            )

            .done(function(response) {
                var output = "";

                if(response.success) {
                    //console.log("Got response", response)
                    var weather = response.data;
                    
                    output += '<div class="conditions">';
                    weather.conditions.forEach(function(condition) {//foreach(weather->conditions as condition)
                    output += '<h1>City: ' + weather.city + '</h1>';                    
                    output += '<img src="http://openweathermap.org/img/w/' +condition.icon+'.png" alt="'+condition.main+'" title="'+condition.description+'">';
                    output += '<strong>Airpressure:</strong>' + weather.pressure + '&nbsp;hpa<br>';
                    output += '<strong>Temperature:</strong> ' + weather.temperature + '&deg; C<br>';
                    output += '<strong>Humidity:</strong> ' + weather.humidity + '%<br>';
                    output += '</div>';
                });
                    
                } else {
                        if(response.data == 404) {
                            output += "Could not find current weather for city.";

                        } else {
                            console.log(response)
                            output += "Something went wrong, please try again🤮";
                            
                        }
                }
                $(current_weather).html(output);
            })
            .fail(function(error) {
                var output = "Unknown error";
                if(error.status == 404) {
                    output = "Could not find weather server.";
                }
                $(current_weather).html(output);
            });
        });
        //fire som async request
        
        });
//deal with response
    

})(jQuery);
