<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
<body>
<ul>

</ul>
<textarea name="" id="dd" cols="30" rows="10">abc</textarea>
</body>
<script>
    let ws = new WebSocket("ws://47.244.119.64:9999");
    ws.onmessage = function (frame) {
        console.log(frame.data);
    };
    ws.onopen = function(){

    };

    document.onkeyup = function (e) {
        if (e.key === 'Enter') {
            let o = {
                cmd: 'login',
                data: document.querySelector('textarea').value
            };
            ws.send(JSON.stringify(o));
            document.querySelector('textarea').value = '';
        }
    };
</script>
</html>
