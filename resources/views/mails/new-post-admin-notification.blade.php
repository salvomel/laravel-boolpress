<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>A new post has been created!</h2>

    <h3>Post Title: {{ $new_post->title }}</h3>

    <div>Take a look by <a href="{{ route('admin.posts.show', ['post' => $new_post->id]) }}">clicking here</a></div>
</body>
</html>