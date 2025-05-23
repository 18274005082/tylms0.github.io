<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// 初始化玩家数据
$player_data = [
    'level' => 1,
    'health' => 100,
    'exp' => 0
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>生存基地 - <?= htmlspecialchars($_SESSION['user']) ?></title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url('456aff81f4386a78b310b0d331e2d70.jpg') no-repeat center/cover fixed;
            font-family: 'Arial Black', sans-serif;
            overflow: hidden;
        }

        /* 状态信息定位 */
        .status-container {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #FF4444;
            box-shadow: 0 0 15px rgba(255, 68, 68, 0.3);
        }

        .status-item {
            color: #FFF;
            margin: 10px 0;
            text-shadow: 0 0 5px #FF4444;
        }

        .health-bar {
            width: 150px;
            height: 15px;
            background: rgba(70, 0, 0, 0.5);
            border-radius: 7px;
            overflow: hidden;
        }

        .health-progress {
            width: <?= $player_data['health'] ?>%;
            height: 100%;
            background: linear-gradient(90deg, #FF0000, #FF4444);
            transition: width 0.3s;
        }

        /* 按钮容器定位 */
        .menu-container {
            position: absolute;
            bottom: 40px;
            right: 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu-button {
            background: rgba(255, 68, 68, 0.3);
            color: #FFF;
            border: 2px solid #FF4444;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 5px;
            width: 180px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .menu-button:hover {
            background: rgba(255, 68, 68, 0.6);
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(255, 68, 68, 0.4);
        }

        /* 玩家名称样式 */
        .player-name {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #FF4444;
            font-size: 20px;
            text-shadow: 0 0 10px rgba(255, 68, 68, 0.5);
        }
    </style>
</head>
<body>
    <div class="player-name">
        <?= htmlspecialchars($_SESSION['user']) ?>
    </div>

    <!-- 状态信息 -->
    <div class="status-container">
        <div class="status-item">
            等级: LV.<?= $player_data['level'] ?>
        </div>
        <div class="status-item">
            生命值:
            <div class="health-bar">
                <div class="health-progress"></div>
            </div>
        </div>
    </div>

    <!-- 菜单按钮 -->
    <div class="menu-container">
        <button class="menu-button" onclick="location.href='begin.php'">
            ▶ 开始游戏
        </button>
        <button class="menu-button" onclick="location.href='equipment.php'">
            ⚔ 装备系统
        </button>
    </div>
</body>
</html>