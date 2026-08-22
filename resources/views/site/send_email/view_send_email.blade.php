<!<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
<div style="margin: 200px auto ;width: 100%">
    <h1>Gui meial</h1>
    <form method="post" action="{{ route('post_send_email') }}">
        <input type="email" name="email">
        <button type="submit">Gui</button>
    </form>
</div>

</body>
</html>