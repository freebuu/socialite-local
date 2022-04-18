<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('local_socialite/css/app.css') }}" rel="stylesheet" />
    <title>Local socialite</title>
</head>
<body>
    <div id="app">
        <div class="login">
            <div class="login-wrapper">
                <div class="login-column">
                    <h2>Info</h2>
                    <p class="login-info-item">Original Driver: <span>{{ $original_driver }}</span></p>
                    <p class="login-info-item">Client ID: <span>{{ $client_id }}</span></p>
                    <p class="login-info-item">Scopes: <span>{{ $scope }}</span></p>
                    <p class="login-info-item">State: <span>{{ $state ?? '' }}</span></p>
                    <p class="login-info-item">Response type: <span>{{ $response_type }}</span></p>
                    <p class="login-info-item">Redirect: <span>{{ $redirect_uri }}</span></p>
                </div>
                <div class="login-column center">
                    <h2>Login</h2>
                    <form class="login-form" name="login-form" action="{{ \Illuminate\Support\Facades\URL::route('local_socialite.login') }}" method="post">
                        <span class="login-text">@csrf</span>
                        <h3>Response</h3>
                        <div class="login-form-item">
                            <label for="scope" class="form-label">Scope</label>
                            <input type="text" class="form-control" id="scope" name="scope" value="{{ $scope }}">
                        </div>
                        <div class="login-form-item">
                            <label for="redirect" class="form-label">Redirect Uri</label>
                            <input type="text" class="form-control" id="redirect" name="redirect" value="{{ $redirect_uri }}">
                        </div>
                        <h3>Subject</h3>
                        <div class="login-subject">
                            <div class="login-form-item">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="login-form-item">
                                <label for="sub" class="form-label">Sub</label>
                                <input type="text" class="form-control" id="sub" name="sub">
                            </div>
                            <div class="login-form-item">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="login-actions">
                            <button type="submit" class="login-button">
                                Submit
                            </button>
                            <button type="button" class="login-add-button" onclick="addCustomFields()">
                                Add fields
                            </button>
                        </div>
                    </form>
                </div>
                <div class="login-column">
                    <h2>Previous inputs</h2>
                    <div class="login-previous-inputs-wrapper">
                        <ul class="login-previous-inputs"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <script src="{{ asset('local_socialite/js/app.js') }}"></script>
</body>
</html>
