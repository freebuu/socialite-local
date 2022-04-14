<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
                <p>State: {{ $state ?? '' }}</p>
                <p>Response type: {{ $response_type }}</p>
                <p>Redirect: {{ $redirect_uri }}</p>
            </div>
            <div class="col-3">
                <h1>Login</h1>
                <form class="form-control" action="{{ \Illuminate\Support\Facades\URL::route('local_socialite.login') }}" method="post">
                    @csrf
                    <h2>Response</h2>
                    <div class="mb-3">
                        <label for="scope" class="form-label">Scope</label>
                        <input type="text" class="form-control" id="scope" name="scope" value="{{ $scope }}">
                    </div>
                    <div class="mb-3">
                        <label for="redirect_uri" class="form-label">Redirect Uri</label>
                        <input type="text" class="form-control" id="redirect_uri" name="redirect_uri" value="{{ $redirect_uri }}">
                    </div>
                    <h2>Subject</h2>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub" class="form-label">Sub</label>
                        <input type="text" class="form-control" id="sub" name="sub">
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