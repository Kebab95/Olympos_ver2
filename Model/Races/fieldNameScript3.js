;$(document).ready(function() {/*
    $("#raceForm2").on( "submit",function(e){
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
    });*/
    var max_fields      = 10; //maximum input boxes allowed
    var inputs = new Array("");
    for (i=0;i<max_fields;i++){
        inputs[i] = null;
    }
    inputs[0] = field(0);
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(wrapper).append(inputs[0]);
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if (countArrayNulls(inputs) >0){
           // console.log(countArrayNulls(inputs));
            var i = 0;
            while (inputs.length >i && inputs[i] !=null){
                i++;
            }
            inputs[i] = field(i);
            $(wrapper).append(inputs[i]);
            $("#compNumber").val(parseInt($("#compNumber").val())+1);

        }
        else {
            alert("Nem adhat hozzá több kategóriát!");
        }

    });

    $(wrapper).on("click",".remove_field_button", function(e){ //user click on remove text
        e.preventDefault();
        var GrpParent = $(this).parent().closest('div').attr('class').split(' ');
        console.log(GrpParent[0]);
        var res = parseInt(String(GrpParent[0]).replace("fieldGroup", ""));
        console.log(res);
        $("div."+GrpParent[0]).remove();
        inputs[res-1] = null;
        $("#compNumber").val(parseInt($("#compNumber").val())-1);
        //$(this).parent('div').remove(); x--;
    })
});
function countArrayNulls(array){
    var a =0;
    array.forEach(function(entry){
        if (entry==null){
            a++;
        }
    });
    return a;
}
function fieldName(num){
    var a =$('#field'+num+'in').val();
    console.log(a);
    if(a.length>0){
        $('#field'+num+'type').text(a+' Típusa');
        $('#field'+num+'sex').text(a+' Nem beállítása');
        $('#field'+num+'age').text(a+' Minimum Korhatár');
    }
    else {
        $('#field'+num+'type').text('Verseny szám Típusa');
        $('#field'+num+'sex').text('Verseny szám Nem beállítása');
        $('#field'+num+'age').text('Verseny szám Minimum Korhatára');
    }

}
function field(num){
    num++;
    if (num!=1){
        var btn = '<button class="btn btn-danger center-block remove_field_button">Verseny szám törlése</button>';
    }else {
        var btn="";
    }
    var options ="";
    myvar.forEach(function(entry){
        options+='<option value="'+entry[0]+'">'+entry[1]+'</option>';
    });
    return '' +
        '<div class="fieldGroup'+num+'"><hr>'+
            '<div class="form-group row"> <label class="control-label col-md-4" id="field'+num+'lbl">Verseny szám neve</label>'+
                '<div class="col-md-8">'+
                ' <input type="text" name="compName'+num+'" class="form-control" required onkeyup="fieldName('+num+')" id="field'+num+'in">'+
                '</div>'+
            '</div>' +
            '<div class="form-group row">'+
                '<label class="control-label col-md-4" id="field'+num+'type">Verseny szám Típusa</label>'+
                '<div class="col-md-8 row">' +
        '               <div class="col-md-6">'+
                            '<select name="compType'+num+'" class="form-control" id="compTypeSelectList'+num+'">' +
                                '<option selected></option>' +
                                options +
                            '</select>' +
        '               </div>' +
            '               <div class="col-md-6">'+
        '<button type="button" class="btn btn-success" onclick="newCompType('+num+')">Típus hozzáadása</button>' +
        '               </div>' +

                '</div>'+
            '</div>'+
            btn+
        '</div>';
}
