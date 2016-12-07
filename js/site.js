$('#passValAlert1').hide();

$(document).ready(function() {

    function setHeight() {
        windowHeight = $(window).innerHeight();
        $('.body').css('min-height', windowHeight-10);
    };
    setHeight();

    $(window).resize(function() {
        setHeight();
    });
    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        var listItem = $('.results tbody').children('tr');
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

        $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
            return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
        });

        $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','false');
        });

        $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','true');
        });

        var jobCount = $('.results tbody tr[visible="true"]').length;
        $('.counter').text(jobCount + ' item');

        if(jobCount == '0') {$('.no-result').show();}
        else {$('.no-result').hide();}
    });
});
function asd(){
    $('#regForm').submit(function(e){

        e.preventDefault(); // Prevent Default Submission
        $('#loadingDiv')
            .hide()  // Hide it initially
            .ajaxStart(function() {
                $(this).show();
            })
            .ajaxStop(function() {
                $(this).hide();
            })
        ;
        $.ajax({
                url: 'model/model_regSubmit.php',
                type: 'POST',
                data: $('#regForm').serialize(), // it will serialize the form data
                dataType: 'html'
            })
            .done(function(data){
                $('#regAll').fadeOut('slow', function(){
                    $('#regAll').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('Ajax Submit Failed ...');
            });
    });
}
function passVal(){
    var pass1 = document.getElementById("regPass");
    var pass2 = document.getElementById("regPass2");

    if(pass1.value.length<5 || !oneUpperCharacter(pass1.value)|| !oneNumberCharacter(pass1.value)){
        pass1.setCustomValidity("Nem egyezik a jelszó feltételeknek");
        return false;
    }
    else {
        pass1.setCustomValidity("");
        if (pass1.value != pass2.value) {
            $('#passVal1').addClass("has-error has-feedback");
            $('#passVal2').addClass("has-error has-feedback");
            /*
             $('#passValAlert1').show();
             $('#passValAlert2').show();
             */
            pass2.setCustomValidity("Jelszavak nem egyeznek");
            // $('#passAlert').show();
            return false;
        }
        else{
            $('#passVal1').removeClass("has-error has-feedback");
            $('#passVal2').removeClass("has-error has-feedback");
            /*
             $('#passValAlert1').hide();
             $('#passValAlert2').hide();
             $('#passAlert').hide();
             */

            pass2.setCustomValidity("");
            return true;




        }
    }

}
function oneUpperCharacter(str){

    var boolean = false;
    var i=0;
    var character='';
    while (i <= str.length){
        character = str.charAt(i);
        if (/^[A-Z]/.test( character)) {
            boolean = true;
        }
        i++;
    }
    return boolean;
}
function oneNumberCharacter(str){
    var boolean = false;
    var i=0;
    var character='';
    while (i <= str.length){
        character = str.charAt(i);
        if (!isNaN(parseInt(character))) {
            boolean = true;
        }
        i++;
    }
    return boolean;
}
function isEmpty(str) {
    return (!str || 0 === str.length);
}