<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Local socialite</title>
</head>
<body>
<div id="app">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <h1>Info</h1>
                <p>Original Driver: {{ $original_driver }}</p>
                <p>Client ID: {{ $client_id }}</p>
                <p>Scopes: {{ $scope }}</p>
                <p>State: {{ $state }}</p>
                <p>Response type: {{ $response_type }}</p>
                <p>Redirect: {{ $redirect_uri }}</p>
            </div>
            <div class="col-3">
                <h1>Login</h1>
                <form class="form-control" action="{{ \Illuminate\Support\Facades\URL::route('local_socialite.login') }}" method="post">
                    @csrf
                    <input type="hidden" name="redirect_uri" value="{{ $redirect_uri }}">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub" class="form-label">Sub</label>
                        <input type="text" class="form-control" id="sub" name="sub">
                    </div>
                    <div class="mb-3">
                        <label for="scope" class="form-label">Scope</label>
                        <input type="text" class="form-control" id="scope" name="scope" value="{{ $scope }}">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <button type="submit" class="btn btn-success">
                        Отправить
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>