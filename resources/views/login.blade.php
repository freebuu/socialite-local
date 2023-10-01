<style>
    * {
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.1px;
        font-weight: 300;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
    }

    .login-column {
        width: 360px;
    }

    .login-column:not(:first-of-type) {
        margin-left: 35px;
    }

    .login-button {
        display: inline-flex;
        margin-top: 16px;
        padding: 10px 24px;
        border-radius: 8px;
        color: #ffffff;
        border: none;
        font-size: 1rem;
        line-height: 1.5rem;
        background-color: rgb(79 70 229);
        transition: background-color 0.2s ease-in-out;
        cursor: pointer;
    }

    .login-button:hover {
        background-color: rgb(67 56 202);
    }

    h2 {
        font-size: 1.875rem;
        line-height: 2.25rem;
        color: rgb(55 65 81);
        letter-spacing: -.025em;
        font-weight: 400;
    }

    h3 {
        font-weight: 400;
    }

    .login-text {
        color: rgb(79 70 229);
    }

    .login-form-item {
        display: flex;
        flex-direction: column;
        margin-bottom: 14px;
    }

    .login-form-item label,
    .login-form-item input,
    .login-form-item span {
        font-size: .875rem;
        line-height: 1.25rem;
        color: rgb(55 65 81);
        font-weight: 400;
    }

    .login-form-item input {
        padding: 0.5rem 0.75rem;
        font-weight: 400;
        border: 1px solid rgb(209 213 219);
        border-radius: 0.375rem;
        outline: none;
    }

    .login-form-item input:-webkit-autofill {
        -webkit-background-clip: text;
    }

    .login-form-item input:focus {
        border-color: rgb(79 70 229);
    }

    .login-info-item {
        color: rgb(55 65 81);
        font-weight: 400;
    }

    .login-info-item span {
        color: rgb(107 114 128);
        font-weight: 300;
    }

    .login-actions {
        display: flex
    }

    .login-add-button {
        margin-left: 24px;
        display: inline-flex;
        margin-top: 16px;
        padding: 10px 24px;
        border-radius: 8px;
        color: rgb(55 65 81);
        border: 1px solid rgb(209 213 219);
        font-size: 1rem;
        line-height: 1.5rem;
        background-color: #fff;
        transition: background-color 0.2s ease-in-out;
        cursor: pointer;
    }

    .login-add-button:hover {
        opacity: 0.8;
    }

    .login-previous-inputs {
        list-style: none;
        padding-left: 0;
        margin: 0;
        max-height: 560px;
        overflow-y: scroll;
    }

    .login-previous-inputs li {
        padding: 10px 24px;
        border: 1px solid rgb(209 213 219);
        border-radius: 8px;
        cursor: pointer;
        transition: border-color 0.2s ease-in-out;
    }

    .login-previous-inputs li:not(:last-of-type) {
        margin-bottom: 14px;
    }

    .login-previous-inputs li:hover {
        border-color: rgb(79 70 229);
    }

    .login-previous-inputs p {
        margin-top: 0;
        margin-bottom: 8px;
    }

    .login-previous-inputs-wrapper {
        position: relative;
    }

    .login-previous-inputs-wrapper:after {
        content: '';
        width: 100%;
        height: 50px;
        position: absolute;
        left: 0;
        bottom: 0;
        background: linear-gradient(transparent 15px, white);
    }
</style>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Socialite Local</title>
</head>
<body>
    <div id="app">
        <div class="login">
            <div class="login-wrapper">
                <div class="login-column">
                    <h2>Request</h2>
                    <p class="login-info-item">Driver: <span>{{ $original_driver }}</span></p>
                    <p class="login-info-item">Client ID: <span>{{ $client_id }}</span></p>
                    <p class="login-info-item">Scopes: <span>{{ $scope }}</span></p>
                    <p class="login-info-item">State: <span>{{ $state ?? '' }}</span></p>
                    <p class="login-info-item">Response type: <span>{{ $response_type }}</span></p>
                    <p class="login-info-item">Redirect: <span>{{ $redirect_uri }}</span></p>
                </div>
                <div class="login-column center">
                    <h2>Response</h2>
                    <form class="login-form" name="login-form" action="{{ \Illuminate\Support\Facades\URL::route('socialite_local.login') }}" method="post">
                        <span class="login-text">@csrf</span>
                        <h3>Authorization</h3>
                        <div class="login-form-item">
                            <label for="scope" class="form-label">Scope</label>
                            <input type="text" class="form-control" id="scope" name="scope" value="{{ $scope }}">
                        </div>
                        <div class="login-form-item">
                            <label for="redirect_uri" class="form-label">Redirect Uri</label>
                            <input type="text" class="form-control" id="redirect_uri" name="redirect_uri" value="{{ $redirect_uri }}">
                        </div>
                        <h3>Subject</h3>
                        <div class="login-subject">
                            <div class="login-form-item">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="login-form-item">
                                <label for="id" class="form-label">Id</label>
                                <input type="text" class="form-control" id="id" name="id">
                            </div>
                            <div class="login-form-item">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="login-actions">
                            <button type="submit" class="login-button">
                                Login
                            </button>
{{--                            <button type="button" class="login-add-button" onclick="addCustomFields()">--}}
{{--                                Add fields--}}
{{--                            </button>--}}
                        </div>
                    </form>
                </div>
{{--                <div class="login-column">--}}
{{--                    <h2>Previous inputs</h2>--}}
{{--                    <div class="login-previous-inputs-wrapper">--}}
{{--                        <ul class="login-previous-inputs"></ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</body>
</html>
<script>
    // let counter = 0;
    // const listItems = document.getElementsByClassName('login-previous-inputs-item');
    // const data = [{
    //     email: 'some-mail-1@google.com',
    //     id: 'sub-1',
    //     name: 'name-1',
    //     'login': 'custom value' // custom field for example
    // },
    //     {
    //         email: 'some-mail-2@google.com',
    //         id: 'sub-2',
    //         name: 'name-2'
    //     },
    //     {
    //         email: 'some-mail-3@google.com',
    //         id: 'sub-3',
    //         name: 'name-3'
    //     },
    //     {
    //         email: 'some-mail-4@google.com',
    //         id: 'sub-4',
    //         name: 'name-4'
    //     },
    //     {
    //         email: 'some-mail-5@google.com',
    //         id: 'sub-5',
    //         name: 'name-5'
    //     }];
    //
    // function renderData() {
    //     const list = document.querySelector('.login-previous-inputs');
    //     let items = [];
    //
    //     for (let i = 0; i < data.length; i++) {
    //         items.push(`<li class="login-previous-inputs-item">
    //        ${Object.keys(data[i]).map((key) => `<p class="login-info-item">${key}: <span>${data[i][key]}</span></p>`).join(``)}
    //     </li>`)
    //     }
    //     items = items.join('');
    //     list.insertAdjacentHTML('afterbegin', items)
    //
    //     list.addEventListener('click', function(event) {
    //         selectData(event);
    //     });
    // }
    //
    // function selectData(event) {
    //     const item = event.target.closest('.login-previous-inputs-item')
    //     const index = Array.from(listItems).indexOf(item);
    //     const form = document.forms['login-form'];
    //     const inputs = form.querySelectorAll('input')
    //
    //     if (~index) {
    //         for (let i = 0; i < inputs.length; i++) {
    //             let fieldValue = data[index][form[i].id]
    //             if(fieldValue){
    //                 form[i].value = fieldValue
    //             }
    //         }
    //     }
    // }
    //
    // function addCustomFields () {
    //     const parent = document.querySelector('.login-subject');
    //     const fields = `<div class="login-form-item">
    //     <span class="form-label">Custom property ${counter}</span>
    //     <input style="margin-bottom: 14px;" type="text" class="form-control" id="name-${counter}" name="custom[${counter}][name]" placeholder="name-${counter}">
    //     <input type="text" class="form-control" id="value-${counter}" name="custom[${counter}][value]" placeholder="value-${counter}">
    // </div>`;
    //
    //     parent.insertAdjacentHTML('beforeend', fields);
    //     counter = ++counter;
    // }
    //
    // renderData();
</script>