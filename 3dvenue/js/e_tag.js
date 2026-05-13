/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

    $('#tageditor .background input').on('input',function(){
        let color = $('#t-color').val();
        let alpha = $('#t-alpha').val();
        let aHex = ('0' + (+alpha).toString(16)).slice(-2);
        $('main section *.active').css({'background':color+aHex});
    })


    $('#tageditor .padding input#t-padding').on('input',function(){
        let padding = $(this).val();
        $('main section *.active').css({'padding':''+padding+'px'});
    })

    $('#tageditor .radius input#t-radius').on('input',function(){
        let radius = $(this).val();
        $('main section *.active').css({'border-radius':''+radius+'px'});
    })

    $('#tageditor .border input#t-border').on('input',function(){
        let border = $(this).val();
        $('main section *.active').css({'border-width':''+border+'px'});
        $('main section *.active').css({'border-style':'solid'});
    })

    $('#tageditor .border input#t-bcolor').on('input',function(){
        let color = $(this).val();
        $('main section *.active').css({'border-color':''+color+''});
    })