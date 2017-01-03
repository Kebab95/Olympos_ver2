$(document).ready(function() {
    $("#createRace2").click( function(e){
        e.preventDefault();
        // send ajax
        $.ajax({
            url: 'Model/Races/test2.php', // url where to submit the request
            type : "POST", // type of action POST || GET
            dataType : 'text', // data type
            data : $("#raceForm2").serialize(), // post data || get data
            success : function(result) {
                // you can see the result from the console
                // tab of the developer tools
                console.log(result);
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        })
    });
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(wrapper).append(field(x));
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(field(x)); //add input box
        }
    });

    $(wrapper).on("click",".remove_field_button", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
function fieldName(num){
    var a =$('#field'+num+'in').val();
    if(a.length>0){
        $('#field'+num+'desc').text(a+' Leírása');
        $('#field'+num+'sex').text(a+' Nem beállítása');
        $('#field'+num+'age').text(a+' Minimum Korhatár');
    }
    else {
        $('#field'+num+'desc').text(num+'. Verseny szám Leírása');
        $('#field'+num+'sex').text(num+'. Verseny szám Nem beállítása');
        $('#field'+num+'age').text(num+'. Verseny szám Minimum Korhatára');
    }

}
function field(num){
    if (num!=1){
        var btn = '<button class="btn btn-danger center-block remove_field_button">Verseny szám törlése</button>';
    }else {
        var btn="";
    }
    return '' +
        '<div class="fieldGroup'+num+'"><hr>'+
        '<div class="form-group row"> <label class="control-label col-md-4" id="field'+num+'lbl">'+num+'. Verseny szám neve</label>'+
        '<div class="col-md-8">'+
        ' <input type="text" name="egy'+num+'" class="form-control" onkeyup="fieldName('+num+')" id="field'+num+'in">'+
        '</div>'+
        '</div>' +
        '<div class="form-group row">'+
        '<label class="control-label col-md-4" id="field'+num+'desc">'+num+'. Verseny szám Leírása</label>'+
        '<div class="col-md-8">'+
        '<textarea class="form-control" name="ketto'+num+'" rows="4" cols="50"></textarea>'+
        '</div>'+
        '</div>' +
        '<div class="form-group row">'+
        '<label class="control-label col-md-4" id="field'+num+'sex">'+num+'. Verseny szám Nem küzdelmek</label>'+
        '<div class="col-md-8">'+
        '<div class="radio">'+
        '<label><input type="radio" name="optradio">2 nem Egymás ellen</label>'+
        '</div>'+
        '<div class="radio">'+
        '<label><input type="radio" name="optradio">2 nem Külön</label>'+
        '</div>'+
        '</div>'+
        '</div>'+
        '<div class="form-group row">'+
        '<label class="control-label col-md-4" id="field'+num+'age">'+num+'. Verseny szám Minimum Korhatára</label>'+
        '<div class="col-md-8">'+
        '<input type="number" name="negy'+num+'" class="form-control">'+
        '</div>'+
        '</div>' +
        btn+
        '</div>';
}
