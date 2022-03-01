function init() {
    var hash = window.location.hash.substr(1);
    $.post(
        "/add/add.php",
        {
            action : "init",
            id : hash
        },
        showOneProduct
    );
}

$(document).ready(function() {
    init();
});

function showOneProduct(data){
    $('.custom-form').html(data);

    const addList = document.querySelector('.add-list');

    if (addList) {

        const form = document.querySelector('.custom-form');
        labelHidden(form);

        const addButton = addList.querySelector('.add-list__item--add');
        const addInput = addList.querySelector('#product-photo');

        checkList(addList, addButton);

        var hash = window.location.hash.substr(1);

        var value = $(addInput).attr('value');

        if (value) {
            const oldTemplate = document.createElement('LI');
            oldTemplate.className = 'add-list__item add-list__item--active';

            oldTemplate.addEventListener('click', evt => {
            addList.removeChild(evt.target);
            addInput.value = '';
            checkList(addList, addButton);


                    

                checkList(addList, addButton);

                addInput.addEventListener('change', evt => {

                    const template = document.createElement('LI');
                    const img = document.createElement('IMG');

                    template.className = 'add-list__item add-list__item--active';
                    template.addEventListener('click', evt => {
                        addList.removeChild(evt.target);
                        addInput.value = '';
                        checkList(addList, addButton);
                    });

                    const file = evt.target.files[0];
                    const reader = new FileReader();

                    reader.onload = (evt) => {
                        img.src = evt.target.result;
                        template.appendChild(img);
                        addList.appendChild(template);
                        checkList(addList, addButton);
                    };

                    reader.readAsDataURL(file);

                });
            
        });

    const oldImg = document.createElement('IMG');
    oldImg.src = value;
    oldTemplate.appendChild(oldImg);
    addList.appendChild(oldTemplate);
    checkList(addList, addButton);
}

    const button = document.querySelector('.button');
    const popupEnd = document.querySelector('.page-add__popup-end');

    button.addEventListener('click', (evt) => {

    evt.preventDefault();

    let productData = [];

    productData = $("form").serialize();
    //console.log(productData);

    addOnDb(productData);

    function addOnDb(data) {

        let hash = window.location.hash.substr(1);
        data += '&id=' + hash;

        if (document.querySelector('.add-list__item img') !== null) {
            let base = document.querySelector('.add-list__item img').getAttribute('src');
            data += '&imgBaseString=' + base;
        } else {
            data += '&imgBaseString=none';
        }

        $.ajax({
            url         : '/add/addOnDb.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            dataType    : 'json',
            processData : false,
            error: catalogError,
            success: function(responce) {

                    if (responce.result === 'success') {

                        form.hidden = true;
                        popupEnd.hidden = false;

                    } else if (responce.result ==='error') {
                        catalogError(responce);
                    }
                }
        });

    }

    function catalogError(responce) {
                alert(responce.text);
            }

    })

}

    var hash = window.location.hash.substr(1);
    if (hash != 0){
        out ='';
        $('.custom-form__input-label').html(out);
    }
}
