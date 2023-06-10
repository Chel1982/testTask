<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            table, th, td {
                border:1px solid black;
            }
        </style>
    </head>
    <body class="antialiased">
        <form method="POST" action="/">
            @csrf
            <div>
                <label for="name" class="form-label">Введите ваше имя</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div>
                <label for="url" class="form-label">Введите ваш url</label>
                <input type="text" class="form-control" name="url">
            </div>
            <button class="btn btn-primary btn-lg" type="submit">Получить короткий url</button>
        </form>
        <form method="get" action="/show">
{{--            @csrf--}}
            <div>
                <label for="name" class="form-label">Получите данные пользователя</label>
                <input type="text" class="form-control" name="user_name">
            </div>
            <button class="btn btn-primary btn-lg" type="submit">Получить данные</button>
        </form>
        @if(isset($shot_url))
            <p>
                <a onclick="stats()" id="short_url" href={{$url}}>{{$shot_url}}</a>
            </p>
        @endif
        @if(isset($http_error))
            Данного Url'a не существует
        @endif
        @if(isset($table))
            Имя пользователя: {{$name_user->name}}
            <table>
                <tr>
                    <th>
                        URL
                    </th>
                    <th>
                        SHOT_URL
                    </th>
                    <th>
                        COUNT
                    </th>
                </tr>
                @foreach($urls as $url)
                <tr>
                    <td>
                        {{$url->url}}
                    </td>
                    <td>
                        {{$url->shot_url}}
                    </td>
                    <td>
                        {{$url->count}}
                    </td>
                </tr>
    {{--                {{$url}}--}}
                @endforeach
            </table>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </body>
</html>
<script>
    function stats() {
        const shot_url = document.getElementById("short_url").textContent;
        const token = document.getElementsByName("_token")[0].value;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "http://127.0.0.1:8001/stats");
        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("X-CSRF-Token", token);

        let data = `{
          "shot_url": "` + shot_url + `"
        }`;

        xhr.send(data);
    }
</script>
