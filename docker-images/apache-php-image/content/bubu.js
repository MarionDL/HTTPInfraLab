$(function() {
        console.log("Loading Bubu verses...");

        function loadPoem() {
                $.getJSON( "/api/bubu/", function(bubu) {
                        console.log(bubu);
                        var message = "Nothing to show...";
                        if(bubu.length > 0) {
                                message = bubu[0];
                        }
                        $(".display-4").text(message);
                });
        };

        loadPoem();
        setInterval(loadPoem, 1000);
});