let counter = 0;
const listItems = document.getElementsByClassName('login-previous-inputs-item');
const data = [{
    scope: '1',
    redirect: 'http://some-uri-1.com',
    email: 'some-mail-1@google.com',
    sub: 'sub-1',
    name: 'name-1',
    'name-0': 'custom value' // custom field for example
},
{
    scope: '2',
    redirect: 'http://some-uri-2.com',
    email: 'some-mail-2@google.com',
    sub: 'sub-2',
    name: 'name-2'
},
{
    scope: '3',
    redirect: 'http://some-uri-3.com',
    email: 'some-mail-3@google.com',
    sub: 'sub-3',
    name: 'name-3'
},
{
    scope: '4',
    redirect: 'http://some-uri-4.com',
    email: 'some-mail-4@google.com',
    sub: 'sub-4',
    name: 'name-4'
},
{
    scope: '5',
    redirect: 'http://some-uri-5.com',
    email: 'some-mail-5@google.com',
    sub: 'sub-5',
    name: 'name-5'
}];

function renderData() {
    const list = document.querySelector('.login-previous-inputs');
    let items = [];

    for (let i = 0; i < data.length; i++) {
        items.push(`<li class="login-previous-inputs-item">
           ${Object.keys(data[i]).map((key) => `<p class="login-info-item">${key}: <span>${data[i][key]}</span></p>`).join(``)}
        </li>`)
    }
    items = items.join('');
    list.insertAdjacentHTML('afterbegin', items)

    list.addEventListener('click', function(event) {
        selectData(event);
    });
}

function selectData(event) {
    const item = event.target.closest('.login-previous-inputs-item')
    const index = Array.from(listItems).indexOf(item);
    const form = document.forms['login-form'];
    const inputs = form.querySelectorAll('input')

    if (~index) {
        for (let i = 0; i < inputs.length; i++) {
            form[i].value = data[index][form[i].id] || '';
        }
    }
}

function addCustomFields () {
    const parent = document.querySelector('.login-subject');
    const fields = `<div class="login-form-item">
        <span class="form-label">Custom property ${counter}</span>
        <input style="margin-bottom: 14px;" type="text" class="form-control" id="name-${counter}" name="name-${counter}" placeholder="name-${counter}">
        <input type="text" class="form-control" id="value-${counter}" name="value-${counter}" placeholder="value-${counter}">
    </div>`;

    parent.insertAdjacentHTML('beforeend', fields);
    counter = ++counter;
}

renderData();
