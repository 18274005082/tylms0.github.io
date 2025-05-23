<!DOCTYPE html>
<html>
<body style="margin: 0;">
<canvas id="game"></canvas>
<div style="position: fixed; top: 10px; left: 10px; color: white; font-family: Arial; background: rgba(0,0,0,0.5); padding: 5px; display: none;" id="hud">
    <div>等级: <span id="lvl">1</span></div>
    <div>血量: <span id="hp">100</span></div>
    <div>金币: <span id="gold">0</span></div>
    <div>关卡: <span id="stage">1</span></div>
    <div>子弹: <span id="ammo">∞</span></div>
</div>
<div id="pauseMenu" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; justify-content: center; align-items: center; z-index: 100;">
    <div style="background: black; padding: 30px; border-radius: 10px; color: white; text-align: center;">
        <h2 id="menuTitle">游戏暂停</h2>
        <button id="resumeBtn" style="margin: 10px; padding: 10px 20px; background: blue; color: white; border: none; border-radius: 5px; cursor: pointer;">继续游戏</button>
        <button id="shopBtn" style="margin: 10px; padding: 10px 20px; background: #9b59b6; color: white; border: none; border-radius: 5px; cursor: pointer;">商店</button>
        <button id="restartBtn" style="margin: 10px; padding: 10px 20px; background: green; color: white; border: none; border-radius: 5px; cursor: pointer;">重新开始</button>
        <button id="exitBtn" style="margin: 10px; padding: 10px 20px; background: red; color: white; border: none; border-radius: 5px; cursor: pointer;">退出游戏</button>
        <button id="musicToggle" style="margin: 10px; padding: 10px 20px; background: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer;">音乐: 开</button>
    </div>
</div>
<div id="startCountdown" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); display: flex; justify-content: center; align-items: center; z-index: 200; color: white; font-size: 80px;">
    3
</div>
<div id="levelUpMenu" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.9); padding: 30px; color: white; border-radius: 10px; z-index: 150; text-align: center;">
    <h2>选择升级</h2>
    <button id="upgradeHp" style="margin: 10px; padding: 10px 20px; background: #e74c3c; color: white; border: none; border-radius: 5px; cursor: pointer;">增加血量</button>
    <button id="upgradeDamage" style="margin: 10px; padding: 10px 20px; background: #f39c12; color: white; border: none; border-radius: 5px; cursor: pointer;">增加伤害</button>
    <button id="upgradeSpeed" style="margin: 10px; padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">增加子弹速度</button>
</div>
<div id="shopMenu" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.9); padding: 30px; color: white; border-radius: 10px; z-index: 150; text-align: center; width: 400px;">
    <h2>商店</h2>
    <p>当前金币: <span id="shopGold">0</span></p>
    <div class="shop-item">
        <div>满血恢复</div>
        <div>价格: 10金币</div>
        <button id="buyHeal" style="margin: 10px; padding: 5px 10px; background: #e74c3c; color: white; border: none; border-radius: 5px; cursor: pointer;">购买</button>
    </div>
    <div class="shop-item">
        <div>永久增加最大血量</div>
        <div>价格: 20金币</div>
        <button id="buyMaxHp" style="margin: 10px; padding: 5px 10px; background: #e74c3c; color: white; border: none; border-radius: 5px; cursor: pointer;">购买</button>
    </div>
    <div class="shop-item">
        <div>增加子弹伤害</div>
        <div>价格: 15金币</div>
        <button id="buyDamage" style="margin: 10px; padding: 5px 10px; background: #f39c12; color: white; border: none; border-radius: 5px; cursor: pointer;">购买</button>
    </div>
    <div class="shop-item">
        <div>增加子弹速度</div>
        <div>价格: 15金币</div>
        <button id="buySpeed" style="margin: 10px; padding: 5px 10px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">购买</button>
    </div>
    <div class="shop-item">
        <div>减少射击冷却</div>
        <div>价格: 20金币</div>
        <button id="buyFireRate" style="margin: 10px; padding: 5px 10px; background: #2ecc71; color: white; border: none; border-radius: 5px; cursor: pointer;">购买</button>
    </div>
    <button id="closeShop" style="margin-top: 20px; padding: 10px 20px; background: #34495e; color: white; border: none; border-radius: 5px; cursor: pointer;">关闭商店</button>
</div>

<!-- 音频元素 - 增加备用格式和错误处理 -->
<audio id="gunshot" preload="auto">
    <source src="枪声.mp3" type="audio/mpeg">
    <source src="枪声.ogg" type="audio/ogg">
    <!-- 备用在线资源，若本地文件加载失败则使用 -->
    <source src="https://assets.mixkit.co/sfx/preview/mixkit-gunshot-hit-1699.mp3" type="audio/mpeg">
</audio>
<audio id="backgroundMusic" loop preload="auto">
    <source src="背景.mp3" type="audio/mpeg">
    <source src="背景.ogg" type="audio/ogg">
</audio>
<audio id="zombieDeath" preload="auto">
    <source src="https://assets.mixkit.co/sfx/preview/mixkit-zombie-roar-1957.mp3" type="audio/mpeg">
</audio>
<audio id="levelUpSound" preload="auto">
    <source src="https://assets.mixkit.co/sfx/preview/mixkit-achievement-bell-600.mp3" type="audio/mpeg">
</audio>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// 音频元素
const gunshot = document.getElementById('gunshot');
const backgroundMusic = document.getElementById('backgroundMusic');
const zombieDeath = document.getElementById('zombieDeath');
const levelUpSound = document.getElementById('levelUpSound');
let isMusicPlaying = false;

// 检查枪声是否加载成功
gunshot.onerror = () => {
    console.log("枪声文件加载失败，使用备用资源");
};

let player = {
    x: 400, y: 300, size: 20, hp: 100, maxHp: 100,
    speed: 5, exp: 0, lvl: 1, gold: 0,
    damage: 10,
    bulletSpeed: 15,
    fireRate: 200,
    lastFired: 0,
    hasShield: false,
    shieldDuration: 0
};
let zombies = [];
let bullets = [];
let expOrbs = [];
let crates = [];
let currentStage = 1;
let isPaused = false;
let isGameOver = false;
let countdown = 3;
let isLevelingUp = false;
let isInShop = false;

const keys = { a: false, d: false, w: false, s: false };

// 减小僵尸移动速度
function spawnZombie() {
    zombies.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        size: 25,
        hp: 50 + currentStage * 5,
        speed: 0.7 + currentStage * 0.07
    });
}

function gameLoop() {
    if (!isPaused && !isGameOver && !isLevelingUp && !isInShop) {
        ctx.fillStyle = '#2c3e50';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // 更新护盾状态
        if (player.hasShield) {
            player.shieldDuration--;
            if (player.shieldDuration <= 0) {
                player.hasShield = false;
            }
        }

        // 玩家移动
        if (keys.a) player.x -= player.speed;
        if (keys.d) player.x += player.speed;
        if (keys.w) player.y -= player.speed;
        if (keys.s) player.y += player.speed;

        // 边界检测
        player.x = Math.max(player.size, Math.min(canvas.width - player.size, player.x));
        player.y = Math.max(player.size, Math.min(canvas.height - player.size, player.y));

        // 更新僵尸
        zombies.forEach(z => {
            let angle = Math.atan2(player.y - z.y, player.x - z.x);
            z.x += Math.cos(angle) * z.speed;
            z.y += Math.sin(angle) * z.speed;

            // 碰撞检测
            if (Math.hypot(player.x-z.x, player.y-z.y) < player.size + z.size) {
                if (!player.hasShield) {
                    player.hp -= 0.5;
                } else {
                    // 护盾抵挡伤害
                    drawShieldEffect(z.x, z.y);
                }
            }
        });

        // 更新子弹
        bullets.forEach((b, i) => {
            b.x += b.dx;
            b.y += b.dy;
            
            if (b.x < 0 || b.x > canvas.width || b.y < 0 || b.y > canvas.height) {
                bullets.splice(i, 1);
                return;
            }
            
            zombies.forEach((z, j) => {
                if (Math.hypot(b.x-z.x, b.y-z.y) < z.size) {
                    z.hp -= b.damage;
                    drawHitEffect(b.x, b.y);
                    bullets.splice(i, 1);
                    if (z.hp <= 0) {
                        drawDeathEffect(z.x, z.y);
                        playZombieDeathSound(); // 播放僵尸死亡音效
                        expOrbs.push({x: z.x, y: z.y, value: 15});
                        if (Math.random() < 0.3) player.gold++;
                        zombies.splice(j, 1);
                    }
                }
            });
        });

        // 经验球
        expOrbs.forEach((orb, i) => {
            if (Math.hypot(player.x-orb.x, player.y-orb.y) < 30) {
                player.exp += orb.value;
                expOrbs.splice(i, 1);
                if (player.exp >= 100) levelUp();
            }
        });

        // 关卡推进
        if (zombies.length === 0) {
            currentStage++;
            for (let i = 0; i < currentStage * 2; i++) spawnZombie();
            crates.push({x: Math.random()*canvas.width, y: Math.random()*canvas.height});
        }

        // 绘制元素
        // 绘制玩家
        ctx.fillStyle = '#3498db';
        ctx.beginPath();
        ctx.arc(player.x, player.y, player.size, 0, Math.PI * 2);
        ctx.fill();
        
        // 绘制护盾
        if (player.hasShield) {
            ctx.strokeStyle = '#8e44ad';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.arc(player.x, player.y, player.size + 5, 0, Math.PI * 2);
            ctx.stroke();
        }
        
        // 绘制玩家方向指示器
        ctx.strokeStyle = '#ffffff';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(player.x, player.y);
        ctx.lineTo(player.x + Math.cos(player.angle) * (player.size + 10), 
                   player.y + Math.sin(player.angle) * (player.size + 10));
        ctx.stroke();

        // 绘制僵尸
        zombies.forEach(z => {
            ctx.fillStyle = '#e74c3c';
            ctx.beginPath();
            ctx.arc(z.x, z.y, z.size, 0, Math.PI*2);
            ctx.fill();
            
            // 绘制僵尸血量条
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(z.x - z.size, z.y - z.size - 10, z.size * 2, 5);
            ctx.fillStyle = '#2ecc71';
            ctx.fillRect(z.x - z.size, z.y - z.size - 10, (z.hp / (50 + currentStage * 5)) * z.size * 2, 5);
        });

        // 绘制经验球
        expOrbs.forEach(orb => {
            ctx.fillStyle = '#2ecc71';
            ctx.beginPath();
            ctx.arc(orb.x, orb.y, 5, 0, Math.PI*2);
            ctx.fill();
        });

        // 绘制子弹
        bullets.forEach(b => {
            ctx.fillStyle = '#f1c40f';
            ctx.beginPath();
            ctx.arc(b.x, b.y, 5, 0, Math.PI*2);
            ctx.fill();
        });

        // 更新界面
        document.getElementById('lvl').textContent = player.lvl;
        document.getElementById('hp').textContent = Math.floor(player.hp);
        document.getElementById('gold').textContent = player.gold;
        document.getElementById('stage').textContent = currentStage;
        document.getElementById('shopGold').textContent = player.gold;
    } else if (isPaused || isLevelingUp || isInShop) {
        ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    // 检查游戏结束
    if (player.hp <= 0 && !isGameOver) {
        gameOver();
    }

    requestAnimationFrame(gameLoop);
}

function drawHitEffect(x, y) {
    ctx.fillStyle = '#f39c12';
    ctx.beginPath();
    ctx.arc(x, y, 8, 0, Math.PI*2);
    ctx.fill();
}

function drawDeathEffect(x, y) {
    ctx.fillStyle = '#e74c3c';
    ctx.beginPath();
    ctx.arc(x, y, 15, 0, Math.PI*2);
    ctx.fill();
}

function drawShieldEffect(x, y) {
    ctx.fillStyle = '#8e44ad';
    ctx.beginPath();
    ctx.arc(x, y, 10, 0, Math.PI*2);
    ctx.fill();
}

function levelUp() {
    player.lvl++;
    player.exp = 0;
    isLevelingUp = true;
    document.getElementById('levelUpMenu').style.display = 'block';
    playLevelUpSound(); // 播放升级音效
}

// 打开商店
function openShop() {
    isPaused = true;
    isInShop = true;
    document.getElementById('shopMenu').style.display = 'block';
    document.getElementById('shopGold').textContent = player.gold;
}

// 关闭商店
function closeShop() {
    isInShop = false;
    document.getElementById('shopMenu').style.display = 'none';
    // 保持isPaused为true，使游戏继续暂停
}

// 事件监听
window.addEventListener('keydown', e => {
    if (isLevelingUp || isInShop) return;
    keys[e.key] = true;
    if (e.key === 'Escape' && !isGameOver) {
        togglePause();
    }
});
window.addEventListener('keyup', e => {
    if (isLevelingUp || isInShop) return;
    keys[e.key] = false;
});

// 鼠标控制
let mouseX = 0;
let mouseY = 0;

canvas.addEventListener('mousemove', e => {
    if (isLevelingUp || isInShop) return;
    mouseX = e.clientX;
    mouseY = e.clientY;
    player.angle = Math.atan2(mouseY - player.y, mouseX - player.x);
});

canvas.addEventListener('click', e => {
    if (isPaused || isGameOver || isLevelingUp || isInShop) return;
    
    const now = Date.now();
    if (now - player.lastFired < player.fireRate) return;
    
    player.lastFired = now;
    
    let angle = Math.atan2(e.clientY - player.y, e.clientX - player.x);
    bullets.push({
        x: player.x, 
        y: player.y,
        dx: Math.cos(angle) * player.bulletSpeed,
        dy: Math.sin(angle) * player.bulletSpeed,
        damage: player.damage
    });
    
    playGunshot(); // 播放枪声
});

// 播放枪声（增强错误处理）
function playGunshot() {
    try {
        const gunshotClone = gunshot.cloneNode();
        gunshotClone.volume = 0.9; // 提高音量确保可听见
        gunshotClone.play().catch(e => {
            console.log("枪声播放失败:", e);
            // 备用方案：使用在线资源
            const backupGunshot = new Audio("https://assets.mixkit.co/sfx/preview/mixkit-gunshot-hit-1699.mp3");
            backupGunshot.volume = 0.7;
            backupGunshot.play().catch(backupErr => console.log("备用枪声播放失败:", backupErr));
        });
    } catch (error) {
        console.log("枪声处理错误:", error);
    }
}

// 播放僵尸死亡音效
function playZombieDeathSound() {
    const zombieDeathClone = zombieDeath.cloneNode();
    zombieDeathClone.volume = 0.2;
    zombieDeathClone.play().catch(e => console.log("僵尸音效播放失败:", e));
}

// 播放升级音效
function playLevelUpSound() {
    const levelUpClone = levelUpSound.cloneNode();
    levelUpClone.volume = 0.5;
    levelUpClone.play().catch(e => console.log("升级音效播放失败:", e));
}

// 播放背景音乐
function toggleMusic() {
    isMusicPlaying = !isMusicPlaying;
    const musicToggleBtn = document.getElementById('musicToggle');
    
    if (isMusicPlaying) {
        backgroundMusic.volume = 0.6;
        backgroundMusic.play().catch(e => {
            console.log("背景音乐播放失败:", e);
            isMusicPlaying = false;
            musicToggleBtn.textContent = "音乐: 开";
        });
        musicToggleBtn.textContent = "音乐: 关";
    } else {
        backgroundMusic.pause();
        musicToggleBtn.textContent = "音乐: 开";
    }
}

// 暂停功能
function togglePause() {
    isPaused = !isPaused;
    if (isPaused) {
        document.getElementById('pauseMenu').style.display = 'flex';
        if (isMusicPlaying) backgroundMusic.pause();
    } else {
        document.getElementById('pauseMenu').style.display = 'none';
        if (isMusicPlaying) backgroundMusic.play();
    }
    document.getElementById('menuTitle').textContent = "游戏暂停";
}

// 游戏结束
function gameOver() {
    isGameOver = true;
    document.getElementById('menuTitle').textContent = "游戏结束";
    document.getElementById('resumeBtn').style.display = 'none';
    document.getElementById('shopBtn').style.display = 'none';
    document.getElementById('exitBtn').textContent = "返回";
    document.getElementById('pauseMenu').style.display = 'flex';
    if (isMusicPlaying) backgroundMusic.pause();
}

// 继续游戏
document.getElementById('resumeBtn').addEventListener('click', () => {
    isPaused = false;
    document.getElementById('pauseMenu').style.display = 'none';
    if (isMusicPlaying) backgroundMusic.play();
});

// 打开商店
document.getElementById('shopBtn').addEventListener('click', openShop);

// 关闭商店
document.getElementById('closeShop').addEventListener('click', closeShop);

// 重新开始
document.getElementById('restartBtn').addEventListener('click', () => {
    player = {
        x: 400, y: 300, size: 20, hp: 100, maxHp: 100,
        speed: 5, exp: 0, lvl: 1, gold: 0,
        damage: 10,
        bulletSpeed: 15,
        fireRate: 200,
        lastFired: 0,
        hasShield: false,
        shieldDuration: 0
    };
    zombies = [];
    bullets = [];
    expOrbs = [];
    crates = [];
    currentStage = 1;
    isPaused = false;
    isGameOver = false;
    isLevelingUp = false;
    isInShop = false;
    document.getElementById('pauseMenu').style.display = 'none';
    document.getElementById('levelUpMenu').style.display = 'none';
    document.getElementById('shopMenu').style.display = 'none';
    document.getElementById('resumeBtn').style.display = 'block';
    document.getElementById('shopBtn').style.display = 'block';
    document.getElementById('exitBtn').textContent = "退出游戏";
    
    for (let i = 0; i < 3; i++) spawnZombie();
    
    // 重新开始时恢复音乐播放状态
    if (isMusicPlaying) {
        backgroundMusic.currentTime = 0;
        backgroundMusic.play().catch(e => console.log("Audio play prevented:", e));
    }
});

// 退出游戏/返回game.php
document.getElementById('exitBtn').addEventListener('click', () => {
    if (isMusicPlaying) backgroundMusic.pause();
    window.location.href = 'game.php';
});

// 升级选择
document.getElementById('upgradeHp').addEventListener('click', () => {
    player.hp += 20;
    player.maxHp += 20;
    document.getElementById('levelUpMenu').style.display = 'none';
    isLevelingUp = false;
});

document.getElementById('upgradeDamage').addEventListener('click', () => {
    player.damage += 5;
    document.getElementById('levelUpMenu').style.display = 'none';
    isLevelingUp = false;
});

document.getElementById('upgradeSpeed').addEventListener('click', () => {
    player.bulletSpeed += 2;
    player.fireRate = Math.max(100, player.fireRate - 20);
    document.getElementById('levelUpMenu').style.display = 'none';
    isLevelingUp = false;
});

// 商店购买功能
document.getElementById('buyHeal').addEventListener('click', () => {
    if (player.gold >= 10) {
        player.gold -= 10;
        player.hp = player.maxHp;
        document.getElementById('shopGold').textContent = player.gold;
        document.getElementById('hp').textContent = Math.floor(player.hp);
        showPurchaseMessage("购买成功: 满血恢复!");
    } else {
        showPurchaseMessage("金币不足!");
    }
});

document.getElementById('buyMaxHp').addEventListener('click', () => {
    if (player.gold >= 20) {
        player.gold -= 20;
        player.maxHp += 20;
        player.hp += 20;
        document.getElementById('shopGold').textContent = player.gold;
        document.getElementById('hp').textContent = Math.floor(player.hp);
        showPurchaseMessage("购买成功: 最大血量增加20!");
    } else {
        showPurchaseMessage("金币不足!");
    }
});

document.getElementById('buyDamage').addEventListener('click', () => {
    if (player.gold >= 15) {
        player.gold -= 15;
        player.damage += 3;
        document.getElementById('shopGold').textContent = player.gold;
        showPurchaseMessage("购买成功: 子弹伤害增加3!");
    } else {
        showPurchaseMessage("金币不足!");
    }
});

document.getElementById('buySpeed').addEventListener('click', () => {
    if (player.gold >= 15) {
        player.gold -= 15;
        player.bulletSpeed += 2;
        document.getElementById('shopGold').textContent = player.gold;
        showPurchaseMessage("购买成功: 子弹速度增加2!");
    } else {
        showPurchaseMessage("金币不足!");
    }
});

document.getElementById('buyFireRate').addEventListener('click', () => {
    if (player.gold >= 20) {
        player.gold -= 20;
        player.fireRate = Math.max(80, player.fireRate - 20); // 最小间隔80ms
        document.getElementById('shopGold').textContent = player.gold;
        showPurchaseMessage("购买成功: 射击冷却减少!");
    } else {
        showPurchaseMessage("金币不足!");
    }
});

// 显示购买消息
function showPurchaseMessage(message) {
    const messageElement = document.createElement('div');
    messageElement.textContent = message;
    messageElement.style.cssText = 'position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.8); color: white; padding: 10px 20px; border-radius: 5px; z-index: 300;';
    document.body.appendChild(messageElement);
    
    setTimeout(() => {
        messageElement.remove();
    }, 2000);
}

// 游戏开始倒计时
function startCountdown() {
    const countdownEl = document.getElementById('startCountdown');
    const hud = document.getElementById('hud');
    
    document.getElementById('pauseMenu').style.display = 'none';
    document.getElementById('levelUpMenu').style.display = 'none';
    document.getElementById('shopMenu').style.display = 'none';
    
    const countdownInterval = setInterval(() => {
        countdown--;
        countdownEl.textContent = countdown;
        
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            countdownEl.style.display = 'none';
            hud.style.display = 'block';
            for (let i = 0; i < 3; i++) spawnZombie();
            gameLoop();
            
            // 开始游戏时尝试播放音乐
            setTimeout(() => {
                toggleMusic();
            }, 1000);
        }
    }, 1000);
}

// 初始化
document.getElementById('musicToggle').addEventListener('click', toggleMusic);
startCountdown();
document.getElementById('pauseMenu').style.display = 'none';
document.getElementById('levelUpMenu').style.display = 'none';
document.getElementById('shopMenu').style.display = 'none';
</script>
</body>
</html>
</html>