$(document).ready(function() {
    getData();
});

function getData(data){
    $.ajax({
    url: '/admin/orders.php',
    data: data,
    type: 'GET',
    cache: false,
    dataType: 'text',
    error: orderListError,
    success: function(responce) {
        if (responce != 1) {
            orderListSuccess(responce);
        } else if  (responce == 0) {
            orderListError(responce);
        }
    }
    });
}

function orderListError(responce) {
    $('.page-order__list').html('Ошибка, попробуйте снова</br></br>');
}

function orderListSuccess(responce) {
    //console.log(responce);
    $('.page-order__list').html(responce);
}

const orders = document.querySelector(".page-order__list");

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

        let id = '';
      const status = evt.target.previousElementSibling;
      if (status.classList && status.classList.contains('order-item__info--no')) {
        status.textContent = 'Выполнено';
        id += '&marker=1';

      } else {
        status.textContent = 'Не выполнено';
        id += '&marker=0';
      }
        const ordersList = orders.querySelectorAll(".order-item__btn");
            let clickVal = evt.target.id;
        if (clickVal != '') {
            id +='&id=' + clickVal;
            getData(id);
            console.log(id);
    }

      status.classList.toggle('order-item__info--no');
      status.classList.toggle('order-item__info--yes');

    }

  });

}