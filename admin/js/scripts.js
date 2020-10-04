$(document).ready(function(){
    // editor
    ClassicEditor
    .create( document.querySelector( '#body' ) )
    .then(editor => {})
    .catch( error => {
        console.error( error );
    } );

    //custom js

    ///////// custom worthless loader //////////////////

    // var div_box = "<div id='load-screen'><div id = 'loading'></div></div>";
    // $("body").prepend(div_box);

    // $("#load-screen").delay(700).fadeOut(600, function(){
    //     $this.remove();
    // })

    ///////// custom worthless loader //////////////////


    ///////// custom loader //////////////////

    // document.onreadystatechange = function () {
    //     var state = document.readyState
    //     if (state == 'complete') {
    //            document.getElementById('interactive');
    //            document.getElementById('load').style.visibility="hidden";
    //     }
    //   }

    ///////// custom loader //////////////////

})

function loadUsersOnline(){
    $.get("functions.php?onlineUsers=result", function(data){
    $(".usersOnLine").text(data);
})
}
setInterval(function(){
    loadUsersOnline();
}, 500)