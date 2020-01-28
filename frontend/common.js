document.addEventListener("click", function (event) {
    var elem = event.target;
    
    if( elem.parentElement.classList.contains('tarif_link') ) elem = elem.parentElement;

    if ( elem.classList.contains('tarif_link') && elem.getAttribute('data-group-id') ) {
        document.querySelector('#screen_1').classList.add('hide');
        document.querySelector('#screen_2').innerHTML = document.querySelector('.content_for_screen_2[data-group-id="'+elem.getAttribute('data-group-id')+'"]').innerHTML;
        document.querySelector('#screen_2').classList.add('show');
        document.querySelector('.nav_bar').classList.add('show');
        document.querySelector('.nav_bar .title').innerText = elem.parentElement.querySelector('h2').innerText;
        document.querySelector('.nav_bar .back').setAttribute('data-group-id',elem.getAttribute('data-group-id'));
    }

    if ( elem.classList.contains('tarif_link') && elem.getAttribute('data-tarif-id') ) {
        document.querySelector('#screen_2').classList.remove('show');
        document.querySelector('#screen_3').innerHTML = document.querySelector('.content_for_screen_3[data-tarif-id="'+elem.getAttribute('data-tarif-id')+'"]').innerHTML;
        document.querySelector('#screen_3').classList.add('show');
        document.querySelector('.nav_bar').classList.add('show');
        document.querySelector('.nav_bar .title').innerText = "Выбор тарифа";
        document.querySelector('.nav_bar .back').setAttribute('data-tarif-id',elem.getAttribute('data-tarif-id'));
    }

    if ( elem.classList.contains('back') ) {
        if
        (
            elem.getAttribute('data-group-id') != null &&
            elem.getAttribute('data-group-id') != '' &&
            document.querySelector('#screen_3').classList.contains('show')
        )
        {
            document.querySelector('#screen_2').classList.add('show');
            document.querySelector('#screen_3').classList.remove('show');
            document.querySelector('.nav_bar .title').innerText = document.querySelector('.tarif_link[data-group-id="'+elem.getAttribute('data-group-id')+'"]').parentElement.querySelector('h2').innerText;
        } else if (document.querySelector('#screen_2').classList.contains('show')){
            document.querySelector('#screen_2').classList.remove('show');
            document.querySelector('.nav_bar').classList.remove('show');
            document.querySelector('#screen_1').classList.remove('hide');
        }
    }

});
