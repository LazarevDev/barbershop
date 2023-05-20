$(document).ready(function(){
    $('.headerBurger').click(function(event){
        $('.headerBurger,.headerMenu').toggleClass('active');
        $('body').toggleClass('lock');
    });
});

$(document).ready(function(){
    $('.headerLink').click(function(event){
        $('.headerBurger,.headerMenu').toggleClass('active');
        $('body').toggleClass('lock');
    });
});
