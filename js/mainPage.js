
$("#sortdir").on("change", getSort);
$("#priceorname").on("change", getSort);
$("#apply").on("click", getSort);
$(".filter__list-item").on("click", getSort);

$(document).ready(function() {
    getSort();
});

const pageItems = document.querySelector(".shop__paginator")
pageItems.addEventListener("click", e => {

    const target = e.target;
    e.preventDefault();
    let pag = null;
    pag = e.target.id;
    let catalogData = null;
    pageNumber = ('&page=' + pag + '&');
    getSort(pageNumber);

});

function getSort(pageNumber = '&page=1')
{
    let categorie = null;
    let url = null;
    catalogData = $("form").serialize();
    catalogData += pageNumber;
    url = window.location.pathname;
    if (url.indexOf('/') != -1) {
        categorie = url.split('/');
    } else if (url.indexOf('\\') != -1) {
        categorie = url.split('\\');
    }

    if (categorie[2] == 'new') {
        catalogData += ('&new=on');
    } else if (categorie[2] == 'sale') {
        catalogData += ('&sale=on');
    } else if (categorie[2] == 'women') {
        catalogData += ('&categorie=women');
    } else if (categorie[2] == 'men') {
        catalogData += ('&categorie=men');
    } else if (categorie[2] == 'kids') {
        catalogData += ('&categorie=kids');
    } else if (categorie[2] == 'acessoires') {
        catalogData += ('&categorie=acessoires');
    }

    //console.log(catalogData);
    getData(catalogData);
    getCount(catalogData);
    getMinMaxPrice(catalogData);
    getPaginator(catalogData);
};

function getPaginator(data)
{
    $.ajax({
    url: '/mainPage/mainPagePaginator.php',
    data: data,
    type: 'POST',
    cache: false,
    dataType: 'text',
    error: catalogError,
    success: function(responce) {
             showPaginator(responce);
        }
    });
}

function showPaginator(responce)
{
    $('.shop__paginator').html(responce);
}


function getCount(data)
{
    $.ajax({
    url: '/mainPage/mainPageProductsCount.php',
    data: data,
    type: 'POST',
    cache: false,
    dataType: 'text',
    error: catalogError,
    success: function(responce) {
             showCount(responce);
        }
    });
}

function showCount(responce)
{
    $('.shop__sorting-res').html(responce);
}

function getMinMaxPrice(data)
{
    $.ajax({
    url: '/mainPage/minMaxPrice.php',
    data: data,
    type: 'POST',
    cache: false,
    dataType: 'text',
    error: catalogError,
    success: function(responce) {
             showMinMaxPrice(responce);
        }
    });
}

function showMinMaxPrice(data)
{
    let prices = JSON.parse(data),
    minPrcResp = prices.min / 1,
    maxPrcResp  = prices.max / 1,
    templateSlider = document.getElementById('slider-template').innerHTML,
    compiled = _.template(templateSlider);
    let getMin = document.getElementById('inputMin').value;
    let getMax = document.getElementById('inputMax').value;
    prices = {min: getMin, max: getMax};

    out = compiled(prices);
    $('.range__res').html(out);

    if (getMin == 0 && getMax == 1000000) {
        $('.max-price').text(maxPrcResp + ' руб.');
        $('.min-price').text(minPrcResp + ' руб.');
    } else {
        $('.max-price').text(getMax + ' руб.');
        $('.min-price').text(getMin + ' руб.');
    }

    if (document.querySelector('.shop-page')) {

        $('.range__line').slider({
            min: minPrcResp,
            max: maxPrcResp,
            values: [getMin, getMax],
            range: true,
            stop: function(event, ui) {

                let formMinPrice = $('.range__line').slider('values', 0);
                let formMaxPrice = $('.range__line').slider('values', 1);

                $('.inputMax').val(formMaxPrice);
                $('.inputMin').val(formMinPrice);
            },
            slide: function(event, ui) {

                $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
                $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
            }
        });
    };
}

function getData(data)
{
    $.ajax({
    url: '/mainPage/mainPage.php',
    data: data,
    type: 'POST',
    cache: false,
    dataType: 'text',
    error: catalogError,
    success: function(responce) {
             catalogSuccess(responce);
        }
    });
}


function catalogError(responce)
{
    $('.shop__list').html('Ошибка, попробуйте снова</br></br>');
}

function catalogSuccess(responce)
{
    //console.log(responce);
    if (responce != '0') {
        $('.shop__list').html(responce);
    } else {
        $('.shop__list').html('Ничего не найдено, попробуйте снова</br></br>');
    }
}
