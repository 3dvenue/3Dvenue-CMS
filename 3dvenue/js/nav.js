/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

$(function(){

// メニューの解除や削除をするための場所を決定する変数
let checkbox = '';
let globalid = '';
let subid = '';
let terid = '';


	$('#nav1 .navtitile').on('click',function(){
		$('#navBox').removeClass();
		$('.navtitile,#nav1 li,#nav2 li,#nav2').removeClass('active');
		$(this).addClass('active');
		$('#navBox').addClass('nav0');
	})

	$('#nav2 .navtitile').on('click',function(){
		$('#navBox').removeClass();
		$('.navtitile,#nav2 li').removeClass('active');
		$(this).addClass('active');
		$('#navBox').addClass('nav1');
	})


// グローバル外部リンク用を追加
	$('#nav0add').on('click',function(){
		console.log('globl');
		// サブメニュー初期化
		$('#nav0,#nav1').removeClass('active');
		$('#navidata').removeClass('active');
		const ts = Date.now();
		let count = $('#nav0 ul li').length;
		if(count >= 7){
			alert('グローバルナビに追加できるメニューは7つまでです');
			$('#nav0add').addClass('hidden');
		}else{
			$('#nav0 ul#navi0Box').append('<li class="content" data-id="'+ts+'" data-pid="0" data-link="" data-target="_self"><span class="name">NEWNAVI</span><span class="slug">/'+ts+'/</span></li>');
		}
	})

// サブメニュー外部リンク用を追加
	$('#nav1add').on('click',function(){
		$('#nav0add .active').data('id');
		$('#navidata').removeClass('active');
		const ts = Date.now();
			$('#nav1 ul#navi1Box').append('<li class="content view" data-parent="'+globalid+'" data-id="'+ts+'" data-pid="0" data-link="" data-target="_self"><span class="name">NEWNAVI</span><span class="slug">/'+ts+'/</span></li>');
	})

// 孫メニュー外部リンク用を追加
	$('#nav2add').on('click',function(){
		console.log('nav2');
		$('#nav1add .active').data('id');
		$('#nav2data').removeClass('active');
		const ts = Date.now();
			$('#nav2 ul#navi2Box').append('<li class="content view" data-parent="'+subid+'" data-id="'+ts+'" data-pid="0" data-link="" data-target="_self"><span class="name">NEWNAVI</span><span class="slug">/'+ts+'/</span></li>');
	})


// 右側サブメニューリストクリック
	$('.menulist').on('click',function(){
		let parentid = "";
		let target = "";
		let pid = this.dataset.pid;
		let name = this.textContent;
		const ts = Date.now();

		if(checkbox == ""){
			parentid = "";
			target = '#nav0 ul#navi0Box';
		}
		if(checkbox == "nav0"){
			parentid = globalid;			
			target = '#nav1 ul#navi1Box';
		}
		if(checkbox == "nav1"){
			parentid = subid;			
			target = '#nav2'+' ul#navi2Box';
		}

		$(target).append('<li class="content view" data-parent="'+parentid+'" data-id="'+ts+'" data-pid="'+pid+'" data-link="" data-target="_self"><span class="name">'+name+'</span><span class="slug">/'+ts+'/</span></li>');

	})


　　//右側ナビゲーションの属性修正画面の保存ボタン
	$('#makenavi').on('click', function () {
		let navid = $(this).attr('data-naviid');
		let name = $('#name').val();
		let slug = $('#slug').val();
		let pid = $('#pid').val();
		let link = $('#link').val();
		let target = $('#target').val();
		var $nav = $('div[data-id="'+navid+'"], li[data-id="'+navid+'"]');
		$nav.find('span.name').text(name);
		$nav.find('span.slug').text(slug);
		$nav.attr({
		  'data-link': link,
		  'data-target': target,
		  'data-pid': pid
		});

		$nav.addClass('flash');
		setTimeout(() => $nav.removeClass('flash'), 500);

	});

	// Nav0メニューをクリック
	$(document).on('click','#nav0 .content',function(){
		$('#nav2').removeClass('active');
		$('#navBox').removeClass();
		$('.navtitile').removeClass('active');
		$('#nav1 .navtitile').addClass('active');		

		$('#navi1Box li').removeClass('view');
		$('#navi2Box li').removeClass('view');
		$('.content.active').not(this).removeClass('active');
		$('#navdock').removeClass();
		$(this).addClass('active');
		globalid = $(this).data('id');
		$('#pid').val($(this).data('pid'));
		$('#link').val($(this).data('link'));
		$('#target').val($(this).data('target'));
		$('#name').val($(this).find('.name').text());
		$('#slug').val($(this).find('.slug').text());
		checkbox = 'nav0';
		$('#nav1').addClass('active');
		$('#navdock').addClass('active nav0');
		$('#navBox').addClass('nav0');
		$('#navi1Box li[data-parent='+globalid+']').addClass('view');
		$('#makenavi').attr('data-naviid',globalid);
		navidata_chaeck();
	})

	// Nav1メニューをクリック
	$(document).on('click','#nav1 .content',function(){
		$('#navi2Box li').removeClass('active');
		$('#navBox').removeClass();
		$('.navtitile').removeClass('active');
		$('#nav2 .navtitile').addClass('active');

		$('#navi2Box li').removeClass('view');
		$('#nav1 .content.active').not(this).removeClass('active');
		$('#navdock').removeClass();
		$(this).addClass('active');
		subid = $(this).data('id');
		$('#pid').val($(this).data('pid'));
		$('#link').val($(this).data('link'));
		$('#target').val($(this).data('target'));
		$('#name').val($(this).find('.name').text());
		$('#slug').val($(this).find('.slug').text());
		$('#checkbox').attr('data-nav','navi1Box');
		checkbox = 'nav1';
		$('#navdock').addClass('active nav1');
		$('#nav2').addClass('active');
		$('#navi2Box li[data-parent='+subid+']').addClass('view');
		$('#navBox').addClass('nav1');
		$('#makenavi').attr('data-naviid',subid);
		navidata_chaeck();
	})

	$(document).on('click','#nav2 .content',function(){
		$('#navBox').removeClass();
		$('#nav2 .content.active').not(this).removeClass('active');
		$('#navdock').removeClass();
		$(this).addClass('active');
		terid = $(this).data('id');
		$('#pid').val($(this).data('pid'));
		$('#link').val($(this).data('link'));
		$('#target').val($(this).data('target'));
		$('#name').val($(this).find('.name').text());
		$('#slug').val($(this).find('.slug').text());
		$('#checkbox').attr('data-nav','navi1Box');
		checkbox = 'nav2';
		$('#navdock').addClass('active nav2');
		$('#navBox').addClass('nav2');
		$('#makenavi').attr('data-naviid',terid);
		navidata_chaeck();
	})


	function navidata_chaeck(){
		let pid = $('#pid').val();
		$('#navidata tr.link').attr('data-hidden',pid);
	}

	$(document).on('click', '#deselect', function(){
		// $('.navtitile').removeClass('active');
	    // $('#'+checkbox+' li.active').removeClass('active');
		let id = $('#'+checkbox+' li.active').attr('data-id');
		console.log(checkbox);

	    if(checkbox == 'nav0'){
			$('#nav0 .navtitile').trigger('click');
			$('#navdock').removeClass();
	    }

	    if(checkbox == 'nav1'){
			$('#navi1Box li.active').removeClass('active');
			$('#navi0Box li.active').trigger('click');
	    }

	    if(checkbox == 'nav2'){
			$('#navi2Box li.active').removeClass('active');	    	
			$('#navi1Box li.active').trigger('click');
	    }

	});


	$('#delbtn').on('click',function(){
		let id = $('#'+checkbox+' li.active').attr('data-id');

		if(checkbox == 'nav1'){
			$('#'+checkbox+' li.active').remove();
			$('#nav2 li[data-parent='+id+']').remove();
			$('#nav0 li.active,#nav0 div.active').trigger('click');
			$('#nav2').removeClass('active');
		}

		if(checkbox == 'nav2'){
			$('#'+checkbox+' li.active').remove();
			$('#nav1 li.active').trigger('click');
		}

	})

	// ナビゲーションの移動
	$('#checkbox #up,#checkbox #left').on('click',function(){
		let navid = $('#makenavi').attr('data-naviid');
		var $nav = $('li[data-id="'+navid+'"]');
		let index = $nav.index();
		$nav.prev().before($nav);
	})

	$('#checkbox #down,#checkbox #right').on('click',function(){
		let navid = $('#makenavi').attr('data-naviid');
		var $nav = $('li[data-id="'+navid+'"]');
		let index = $nav.index();
		$nav.next().after($nav);
	})

	$('#navi_archive').on('click',function(){
		const html = $('#navilists').html();
		$('#navilists').html(html);
	})


	// ナビ操作
$('#nav1-text-based').on('click', function () {
    $('#navitext').addClass('active');

    delete window.nav1Items;
    delete window.nav1Top;
    delete window.nav1Other;

    let items   = {};
    let topList = [];
    let others  = [];

    $('#navi1Box li').each(function () {

        let html     = $(this).prop('outerHTML');
        let parentid = $(this).attr('data-parent');
        let id       = $(this).attr('data-id');
        let name     = $(this).find('span.name').text();

        items[id] = { id, parentid, name, html };

        if (parentid == 0) {
            topList.push(id + ':' + name);
        } else {
            others.push(id);
        }
    });

    window.nav1Items = items;
    window.nav1Top   = topList;
    window.nav1Other = others;

    $('#naviTextArea').val(topList.join("\n"));
});



$('#changeNavi').on('click', function () {
	console.log('機能してない？');
    let lines = $('#naviTextArea').val().trim().split("\n");
    $('#navi1Box').empty();
    lines.forEach(function (line) {
        let id = line.split(':')[0].trim();
        if (window.nav1Items[id]) {
            $('#navi1Box').append(window.nav1Items[id].html);
        }
    });

    window.nav1Other.forEach(function (id) {
        if (window.nav1Items[id]) {
            $('#navi1Box').append(window.nav1Items[id].html);
        }
    });

    delete window.nav1Items;
    delete window.nav1Top;
    delete window.nav1Other;
    
    $('#navitext').removeClass('active');
});

	// 保存ボタンクリック
	$('#navi_upadate').on('click',function(){
		$('#save').addClass('active');
		let html0 = $('#navi0Box').html();
		let html1 = $('#navi1Box').html();
		let html2 = $('#navi2Box').html();
		$('#nav0html').html(html0);
		$('#nav1html').html(html1);
		$('#nav2html').html(html2);
		$('#nav0data').val(html0);
		$('#nav1data').val(html1);
		$('#nav2data').val(html2);
	})

	$('#dnav0,#dnav1,#dnav2').on('click',function(){
		$(this).next('.textarea').find('textarea').toggleClass('active');
	})

	$('#closesave').on('click',function(){
		$('#save').removeClass('active');
	})

	$('#closeNaviText').on('click',function(){
		$('#navitext').removeClass('active');
	});



	// ナビゲーションの作成書き出しまで
	$('#make_html').on('click', function () {
	    let nav = {};   // ← ここは {} でOK（配列ではない）
	    let html = "";
	    let url = "";
	    let p = "";
	    for (let i = 0; i <= 2; i++) {
	        nav[i] = {};
	        $('#navi' + i + 'Box li').each(function () {
	            let id       = $(this).attr('data-id');
	            let pid       = $(this).attr('data-pid');
	            let link	 = $(this).attr('data-link') ?? 'https://mit.e3dvenue.jp';
	            let parent = $(this).attr('data-parent');
	            let target	 = $(this).attr('data-target');
	            let name     = $(this).find('span.name').text();
	            let slug     = $(this).find('span.slug').text();
	            link = 'https://mit.e3dvenue.jp';
	            let url = (pid == 0) ? link : slug;
	            nav[i][id] = {id,pid,parent,name,url,target};
	        });
	    }

		$.each(nav[0], function(id, item){
			if(item.pid == 0){p=''}else{p=' p="'+item.pid+'"'};
		html += '<li'+p+'><a href="'+item.url+'" target="'+item.target+'">'+item.name+'</a>';

		    // 子をまとめて取得（第2階層）
		    let children = [];
		    $.each(nav[1], function(cid, sub){
		        if(sub.parent == item.id){
		            children.push(sub);
		        }
		    });
	    if(children.length > 0){
	    	html += '\n<ul class="nav1">\n';
	        $.each(children, function(i, sub){
				if(sub.pid == 0){p=""}else{p=' p="'+sub.pid+'"'};
	            html += '<li'+p+'><a href="'+sub.url+'" target="'+sub.target+'">' + sub.name + '</a>';
	            let subChildren = [];
	            $.each(nav[2], function(gid, subsub){
	                if(subsub.parent == sub.id){
	                    subChildren.push(subsub);
	                }
	            });
	            if(subChildren.length > 0){
	            	html += '\n<ul class="nav2">\n';
	                $.each(subChildren, function(j, subsub){
					if(subsub.pid == 0){p=""}else{p=' p="'+subsub.pid+'"'};
	                    html += '<li'+p+'><a href="'+subsub.url+'" target="'+subsub.target+'">' + subsub.name + '</a></li>\n';
	                });
	                html += '</ul>\n</li>\n';
	            }else{
	            	html += '</li>\n';
	            }
	        });
	        html += '</ul>\n</li>\n';
	    } else {
	    	html += '</li>';
	    }
	});

		html = '<ul class="nav0">'+html+'</ul>';

		$.post('menu.php', { html: html })
	    .done(function() {
	        location.reload();
	    });

	});


})