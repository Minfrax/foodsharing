$(function() {

    let btn = $('#filterBtn');

    let resBtn = $('#resBtn');

    btn.click(function(){
        event.preventDefault();
        let selectBox = $('#filterCanton');

        selectBox = selectBox.val();
        console.log(selectBox);

        $('#filterList').load(this.dataset.target.replace('__cantonID__', selectBox));

        let content = $('.content');
        $('#filterList').show();
        content.hide();
    });

    resBtn.click(function(){
        event.preventDefault();
        let content = $('.content');
        $('#filterList').hide();
        content.show();
    })
});