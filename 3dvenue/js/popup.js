/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/

$(function(){

    $('#selecter').on('change', function(){
        const tid = $(this).val();
        window.opener.postMessage({ type: 'requestCss', tid }, "*");
    });

    window.addEventListener("message", function(e){
        const msg = e.data;

        // CSS 受け取り
        if (msg.type === 'responseCss') {
            $('#css').val(msg.css);
        }

        // CSS リアルタイム反映
        if (msg.type === 'updateCss') {
            $('#css').val(msg.css);
        }

        // ★ ここが今回の本題：テンプレ一覧更新
        if (msg.type === "refreshTemplates") {

            const sel = document.getElementById("selecter");
            sel.innerHTML = "";

            msg.templates.forEach(t => {
                const opt = document.createElement("option");
                opt.value = t.tid;
                opt.textContent = t.tname;
                sel.appendChild(opt);
            });

            // 新しいテンプレートを選択状態に
            sel.value = msg.newTid;
        }
    });

    $('#css').on('input', function(){
        const css = $(this).val();
        window.opener.postMessage({ type: 'updateCss', css }, "*");
    });

    $('#save').on('click',function(){
        let tid = $('#selecter').val();
        let tname = $('#selecter option:selected').text();
        window.opener.postMessage({
            type: 'save',
            tid: tid,
            tname: tname
        }, '*');
    });

});
