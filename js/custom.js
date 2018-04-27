$(function(){
    
    $('.box').click(function() {
        
        $('.img').hide(400);
        $('.stream').show(400);
        $('.icon-play').hide(400);
        
        var url = $('.stream').attr('src');
            
        
        $('.stream').attr("src", function () {
            
            
            return url.replace("false", "true");
            
        });

        
    });

});

