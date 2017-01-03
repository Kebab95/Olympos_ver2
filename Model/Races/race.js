$(document).ready(function(){
    // click on button submit
    $("#createRace1").click( function(e){
        e.preventDefault();
        // send ajax
        $.ajax({
            url: 'Model/Races/test.php', // url where to submit the request
            type : "POST", // type of action POST || GET
            dataType : 'json', // data type
            data : $("#raceForm1").serialize(), // post data || get data
            success : function(result) {
                // you can see the result from the console
                // tab of the developer tools
                $('#raceCreateBody').fadeOut('slow', function(){

                    $('#raceCreateBody').fadeIn('slow').load("View/Races/view_raceCreate2.php", function(){
                        $("#createRaceHidden").val(JSON.stringify(result));
                    });
                    console.log(JSON.stringify(result));

                });
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        })
    });


});
