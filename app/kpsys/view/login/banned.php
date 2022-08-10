<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>账户已被禁用</title>
		<meta name="renderer" content="bew">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css">
		<link rel="stylesheet" type="text/css" href="/static/bews/css/login.css">
		<link rel="icon" href="//common.jxnews.com.cn/sys/jxnews.ico" type="image/x-icon" />
		<script type="text/javascript" src="/static/layui/layui.js"></script>
    </head>

    <body>
        <h1>账户已被禁用, 即将转到登录界面</h1>
		<script>
			setTimeout(()=>{}, 2000);
            top.location.href = '/index.php/Login/index';
        </script>
    </body>