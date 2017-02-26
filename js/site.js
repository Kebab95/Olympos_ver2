jQuery.loadScript = function (url, callback) {
    jQuery.ajax({
        url: url,
        dataType: 'script',
        success: callback,
        async: true
    });
};
function showModalProfile(myUserID,id){
    $.ajax({
        url: 'Model/model_modal_ajax_Profile.php',
        type: 'POST',
        data: {myUserID: myUserID,id:id},
        dataType: 'html'
    }).done(function(data){
        console.log(data);
        $("#ProfileModalHire").html(data);
        $("#profileModal").modal("show").on('hidden.bs.modal', function () {
            setTimeout(function(){
                $("#ProfileModalHire").html("");
            },500);
        });
        $("#modalProfileClose").on("click",function(){
            $("#profileModal").modal("toggle");

            setTimeout(function(){
                $("#ProfileModalHire").html("");
            },500);

        });

    }).fail(function(){
        alert('Ajax Submit Failed ...');
    });
}
$('#passValAlert1').hide();

$(document).ready(function() {

    if(document.getElementsByClassName("cursor")[0].getAttribute("aria-expanded") =="false") {
        //timer = setInterval(RunUpdate, 3000); // Run once every 0.3 seconds
    }
    else {
        //clearInterval(timer);
    }
    function setHeight() {
        windowHeight = $(window).innerHeight();
        $('.body').css('min-height', windowHeight);
    };
    setHeight();

    $(window).resize(function() {
        setHeight();
    });
    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        var listItem = $('.results tbody').children('tr').children('td:not(.qwe)');
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
        $('.counter').text(jobCount + ' találat');

        if(jobCount == '0') {$('.no-result').show();}
        else {$('.no-result').hide();}
    });
});
function RunUpdate() {
    if(document.getElementsByClassName("cursor")[0].getAttribute("aria-expanded") =="false") {
        console.log("Lefutott");

    }


}
function orgJoinSubmit(number){
    var form = "#orgJoin"+number;
    console.log(form);
    $(form).submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'Model/OrgPage/model_joinOrg.php',
            type: 'POST',
            data: $(form).serialize(),
            dataType: 'html'
        }).done(function(data){
            console.log(data);
            window.location.href = "?nav=home";
            alert("Csatlakozási szándékát elküldtük");
            $('.testDropD').load('js/refreshData.php');
        }).fail(function(){
            alert('Ajax Submit Failed ...');
        });
    });
}
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