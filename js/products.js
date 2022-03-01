
const productsList = document.querySelector('.page-products__list');
if (productsList) {

    productsList.addEventListener('click', evt => {

        const target = evt.target;

        if (target.classList && target.classList.contains('product-item__delete')) {

            let id = evt.target.id;
            //console.log(id);
            data = {id: id};
            deleteProduct(data, productsList);
            productsList.removeChild(target.parentElement);


        }
    });
}

function deleteProduct(data, productsList) {
    $.ajax({
    url: "/products/delete.php",
    data: data,
    type: 'POST',
    cache: false,
    dataType: 'text',
    error: deleteError,
    success: function(responce) {
             deleteSuccess(responce, productsList);
        }
    });
}
function deleteSuccess(responce, productsList) {
    if (responce == '1') {
        productsList.removeChild(target.parentElement); // не работает

    } else {
        //console.log(responce);
    }

}
function deleteError() {
    console.log(errfunc);
}


function showProducts(data){
    $.ajax({
    url: '/products/products.php',
    data: data,
    type: 'GET',
    cache: false,
    dataType: 'text',
    error: productsError,
    success: function(responce) {
             productsSuccess(responce);
        }
    });
}

function productsError(responce) {
    $('.page-products__list').html('Ошибка, попробуйте снова</br></br>');
}
 

function productsSuccess(responce) {
    //console.log(responce);
    if (responce != '0') {
        $('.page-products__list').html(responce);
    } else {
        $('.page-products__list').html('Ничего не найдено, попробуйте снова</br></br>');
    }
}

$(document).ready(function() {
    showProducts();
});
