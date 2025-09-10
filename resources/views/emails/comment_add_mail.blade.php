<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MAil</title>
</head>

<body>
    <h1>New Comment on Your Post</h1>
    <p>User: {{ $comment->user->name }}</p>
    <p>Comment: {{ $comment->content }}</p>
    <p>Post: {{ $comment->post->title }}</p>
</body>

</html>
