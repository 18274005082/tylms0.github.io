<?php
session_start();
$error = '';

if (!file_exists('users.json')) {
    file_put_contents('users.json', json_encode([]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $users = json_decode(file_get_contents('users.json'), true) ?: [];

    if ($action === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (isset($users[$username])) {
            if (password_verify($password, $users[$username])) {
                $_SESSION['user'] = $username;
                header('Location: game.php');
                exit();
            }
        }
        $error = '用户名或密码错误';
    } 
    elseif ($action === 'register') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username)) {
            $error = '用户名不能为空';
        } elseif (empty($password)) {
            $error = '密码不能为空';
        } elseif (isset($users[$username])) {
            $error = '用户名已存在';
        } else {
            $users[$username] = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents('users.json', json_encode($users));
            $_SESSION['user'] = $username;
            header('Location: game.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>欢迎来到游戏</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-image: url('4bb3b2ecc6f028435870958c1576f3c.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0, 123, 255, 0.3);
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h1 { 
            color: #fff; 
            text-shadow: 0 0 10px rgba(0,123,255,0.5); 
        }
        input {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }
        button {
            background: linear-gradient(45deg, #007bff, #00ff88);
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            letter-spacing: 2px;
        }
        .alert-error {
            color: #dc3545;
            padding: 10px;
            margin: 10px 0;
            background: rgba(255,53,53,0.2);
            border-radius: 5px;
        }
        a {
            color: #00ff88;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['action']) && $_GET['action'] === 'register'): ?>
            <h1>游戏注册</h1>
            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <input type="text" name="username" placeholder="玩家名" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="密码" required>
                </div>
                <button type="submit">注册</button>
                <p style="text-align:center;margin-top:15px">
                    已有账号？<a href="?action=login">立即登录</a>
                </p>
            </form>
        <?php else: ?>
            <h1>游戏登录</h1>
            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <input type="text" name="username" placeholder="玩家名" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="密码" required>
                </div>
                <button type="submit">登录</button>
                <p style="text-align:center;margin-top:15px">
                    没有账号？<a href="?action=register">立即注册</a>
                </p>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>