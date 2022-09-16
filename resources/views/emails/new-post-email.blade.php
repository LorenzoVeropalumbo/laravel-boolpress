<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>Ciao amministratore, un nuovo post è stato creato nel blog</h1>

    <div>Il titolo del nuovo post create è: {{ $new_post->title }}</div> 

    <a href="{{ route('admin.post.show', ['post' => $new_post->id]) }}">Clicca qui</a><span>per visuallizare le informazioni del post</span> 

</body>
</html>