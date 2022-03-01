'use strict';

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};



const shopList = document.querySelector('.shop__list');
if (shopList) {

  shopList.addEventListener('click', (evt) => {

    const prod = evt.path || (evt.composedPath && evt.composedPath());;
    
    const target = evt.target;

    let id = evt.target.id;

    $("#id").val(id)

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button');
      const popupEnd = document.querySelector('.shop-page__popup-end');

      buttonOrder.addEventListener('click', (evt) => {

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

        inputs.forEach(inp => {

          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {

          evt.preventDefault();

          let userData = [];
          
          userData = $("form").serialize();

          sendData(userData);

            function sendData(data) {
                $.ajax({
                url: '/order/order.php',
                data: data,
                type: 'POST',
                cache: false,
                dataType: 'json',
                error: orderError,
                success: function(responce) {
                  console.log(responce.result);
                  console.log(responce);

                        if (responce.result === 'success') {
                         toggleHidden(shopOrder, popupEnd);
                        } else {
                          orderError(responce);
                        }
                    }
                });
            }

            function orderError(responce) {
                alert(responce.text);
            }

          popupEnd.classList.add('fade');
          setTimeout(() => popupEnd.classList.remove('fade'), 1000);

          window.scroll(0, 0);

          const buttonEnd = popupEnd.querySelector('.button');

          buttonEnd.addEventListener('click', () => {

            location.href = '/';

            popupEnd.classList.add('fade-reverse');

            setTimeout(() => {

              popupEnd.classList.remove('fade-reverse');

              toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

            }, 1000);

          }
          );

        } else {
          window.scroll(0, 0);
          evt.preventDefault();
        }
      });
    }
  });
}


const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
// const addList = document.querySelector('.add-list');
// if (addList) {

  // const form = document.querySelector('.custom-form');
  // labelHidden(form);

  // const addButton = addList.querySelector('.add-list__item--add');
  // const addInput = addList.querySelector('#product-photo');

  // checkList(addList, addButton);

  // addInput.addEventListener('change', evt => {

  //   const template = document.createElement('LI');
  //   const img = document.createElement('IMG');

  //   template.className = 'add-list__item add-list__item--active';
  //   template.addEventListener('click', evt => {
  //     addList.removeChild(evt.target);
  //     addInput.value = '';
  //     checkList(addList, addButton);
  //   });

  //   const file = evt.target.files[0];
  //   const reader = new FileReader();

  //   reader.onload = (evt) => {
  //     img.src = evt.target.result;
  //     template.appendChild(img);
  //     addList.appendChild(template);
  //     checkList(addList, addButton);
  //   };

  //   reader.readAsDataURL(file);

  // });

  // const button = document.querySelector('.button');
  // const popupEnd = document.querySelector('.page-add__popup-end');

  // button.addEventListener('click', (evt) => {

  //   evt.preventDefault();

  //   form.hidden = true;
  //   popupEnd.hidden = false;

  // })

// }
