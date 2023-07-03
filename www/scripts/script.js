"use strict";

function toggeHide(e) {
    e.target.parentElement.parentElement.querySelector(".item-content").classList.toggle("hide");;
}

let btns = document.querySelectorAll("button.toggle");
for(let btn of btns) {
    btn.addEventListener('click', toggeHide);
}

function updateItemStates(data) {
    fetch("/updatestate.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
          }
    });
}

function update(item) {
    const data = {
        type: item.dataset.idItem ? 'item' : 'subitem',
        id_item: item.dataset.idItem ? item.dataset.idItem : item.dataset.idSubitem,
        value: (+item.checked).toString()
    }
    updateItemStates(data);
}

function processCheck(e) {
    //Был ли изменен статус пункта или подпункта
    let clickedOn = 'subitem';
    if(e.target.dataset.idItem) {
        clickedOn = 'item'
    }

    if (clickedOn == 'item') {
        //Если пункт - записываем
        update(e.target);

        //Получаем подпункты
        let subitems = e.currentTarget.querySelectorAll(".list-subitem input");
        for (let subitem of subitems) {
            // Обновляем в соответсвии с состоянием пункта
            if (subitem.checked != e.target.checked) {
                subitem.checked = e.target.checked;
                update(subitem);
            }
        }
    } else {
        //Если изменили статус подпункта - обновляем
        update(e.target);

        let subitems = e.currentTarget.querySelectorAll(".list-subitem input");
        let item = e.currentTarget.querySelector(".item-header input");
        //Если отмечали
        if(e.target.checked) {
            //Проверяем статус остальных подпунктов
            let allSubItemsChecked = true;
            for (let subitem of subitems) {
                if (!subitem.checked) {
                    allSubItemsChecked = false;
                    break;
                }
            }

            //Если все отмечены - значит пункт тоже выполнен, обновляем
            if(allSubItemsChecked) {
                item.checked = true;
                update(item);
            }
        } else {
            //Если снимали отметку с подпункта
            // снимаем и с пункта, при необходимости
            if (item.checked) {
                item.checked = false;
                update(item);
            }
        }

    }
}

let items = document.querySelectorAll(".list-item>li");
for(let item of items) {
    item.addEventListener('change', processCheck);
}