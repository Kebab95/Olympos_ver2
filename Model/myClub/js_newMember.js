function newMemberFunc(Number){
    $("#newMember"+Number).submit(function(e){
        e.preventDefault();
        var firstname = $('#memberName').val();
        $.ajax({
                url: 'Model/myClub/model_ajax_newMember.php',
                type: 'POST',
                data: $('#newMember'+Number).serialize(), // it will serialize the form data
                dataType: 'text'
            })
            .done(function(data){
                if(data==false){
                    alert("Hiba a hozzáadáskor");
                }
                else {
                    console.log(data);
                    location.reload(true);
                }
            })
            .fail(function(){
                alert('Ajax Submit Failed ...');
            });
    });
}

