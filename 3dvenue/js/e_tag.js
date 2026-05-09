/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

    $('#tageditor .background input').on('input',function(){
        let color = "#FFFFFF";
        let mode = $('.mode:checked').val();
        let tcolor1 = $('#t-color').val();
        let tcolor2 = $('#t-color2').val();
        let talpha1 = $('#t-alpha1').val();
        let talpha2 = $('#t-alpha2').val();
        let tangle = $('#t-angle').val();

        let aHex1 = ('0' + (+talpha1).toString(16)).slice(-2);
        let aHex2 = ('0' + (+talpha2).toString(16)).slice(-2);

        console.log(aHex1);

        if(mode == "grad"){
            $('.gradient').removeClass('hidden');
            color = 'linear-gradient('+tangle+'deg,'+tcolor2+aHex2+','+tcolor1+aHex1+')';
        }else{
            $('.gradient').addClass('hidden');
             color = tcolor1;
        }
        $('main section *.active').css({'background':color});
    })


    $('#tageditor .padding input').on('input',function(){
        let tpad1 = $('#t-padding1').val();
        let tpad2 = $('#t-padding2').val();
        let tpad3 = $('#t-padding3').val();
        let tpad4 = $('#t-padding4').val();
        let padding = tpad1+"px "+tpad2+"px "+tpad3+"px "+tpad4+"px";
        console.log(padding);
        $('main section *.active').css({'padding':''+padding+''});
    })

    $('#tageditor .radius input').on('input',function(){
        let trad1 = $('#t-radius1').val();
        let trad2 = $('#t-radius2').val();
        let trad3 = $('#t-radius3').val();
        let trad4 = $('#t-radius4').val();
        let radius = trad1+"px "+trad2+"px "+trad3+"px "+trad4+"px";
        // console.log(radius);
        $('main section *.active').css({'border-radius':''+radius+''});
    })

    $('#tageditor .border input').on('input',function(){
        let bweight = $('#t-b-weight').val();
        let bstyle = $('#t-bstyle').val();
        let bcolor = $('#t-bcolor').val();
        let border = bweight+"px "+bstyle+" "+bcolor;
        // console.log(border);
        $('main section *.active').css({'border':''+border+''});
    })