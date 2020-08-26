<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('messages.title') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Style -->
        <link href="/style/style.css" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center position-ref">
            <div class="content">

                <h1 class="title m-b-md">
                    {{ __('messages.title') }}
                </h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="messages">
                    @csrf
                    <label>{{ __('messages.form_author') }} *</label>
                    <input type="text" name="author" placeholder="{{ __('messages.form_author') }}"/>
                    <label>{{ __('messages.form_text') }} *</label>
                    <textarea name="text" placeholder="{{ __('messages.form_text') }}"></textarea>
                    <input type="submit" value="{{ __('messages.form_submit') }}" name="submit" />
                </form>

                <div class="messages-items">
                    @foreach ($messages as $message)
                        <div class="item">
                            <span class="message-author">{{ $message->author }}</span>
                            <p>{{ $message->text }}</p>
                            @if (App::isLocale('ru'))
                                <span class="message-date">{{ date('d.m.Y H:i:s', strtotime($message->created_at)) }}</span>
                            @else
                                <span class="message-date">{{ date('Y-m-d H:i:s', strtotime($message->created_at)) }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div>
                    {{ $messages->links() }}
                </div>

            </div>
        </div>
    </body>
</html>
