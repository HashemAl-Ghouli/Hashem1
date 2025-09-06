<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لعبة إطلاق النار على النجوم</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #0d1117;
            color: #e6edf3;
            font-family: 'Cairo', sans-serif;
            overflow: hidden;
            flex-direction: column;
        }
        #game-container {
            position: relative;
            width: 80vw;
            height: 80vh;
            border: 2px solid #30363d;
            background-color: #161b22;
            overflow: hidden;
            cursor: none;
        }
        #player {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
            border-bottom: 50px solid #58a6ff;
            pointer-events: none;
            box-shadow: 0 0 10px #58a6ff;
        }
        .star {
            position: absolute;
            color: #ffd33d;
            font-size: 24px;
            pointer-events: none;
            user-select: none;
        }
        .bullet {
            position: absolute;
            width: 8px;
            height: 8px;
            background-color: #e6edf3;
            border-radius: 50%;
            pointer-events: none;
            box-shadow: 0 0 5px #e6edf3;
        }
        .message-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #21262d;
            border: 2px solid #30363d;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .message-box h2 {
            margin-top: 0;
            font-size: 2em;
            color: #e6edf3;
        }
        .message-box button {
            background-color: #238636;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            margin-top: 15px;
            transition: background-color 0.3s;
        }
        .message-box button:hover {
            background-color: #2ea043;
        }
        .score-display {
            margin: 10px 0;
            font-size: 1.2em;
            color: #c9d1d9;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="score-display">النقاط: 0</div>
    <div id="game-container">
        <div id="player"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const gameContainer = document.getElementById('game-container');
            let player = document.getElementById('player');
            const scoreDisplay = document.querySelector('.score-display');
            let score = 0;
            let isGameOver = true;
            let starInterval;
            let animationFrameId;
            let bulletInterval;

            const containerWidth = gameContainer.clientWidth;
            const containerHeight = gameContainer.clientHeight;
            const playerSize = 50;
            let playerX = containerWidth / 2 - playerSize / 2;
            let playerY = containerHeight - playerSize - 20;

            player.style.left = `${playerX}px`;
            player.style.top = `${playerY}px`;

            function showMessageBox(message, buttonText, onButtonClick) {
                if (document.querySelector('.message-box')) return;
                const messageBox = document.createElement('div');
                messageBox.className = 'message-box';
                messageBox.innerHTML = `
                    <h2>${message}</h2>
                    <button>${buttonText}</button>
                `;
                document.body.appendChild(messageBox);
                document.getElementById('game-container').style.cursor = 'default';
                messageBox.querySelector('button').addEventListener('click', () => {
                    document.body.removeChild(messageBox);
                    document.getElementById('game-container').style.cursor = 'none';
                    if (onButtonClick) {
                        onButtonClick();
                    }
                });
            }

            function startGame() {
                isGameOver = false;
                score = 0;
                scoreDisplay.textContent = 'النقاط: 0';
                
                document.querySelectorAll('.star').forEach(star => star.remove());
                document.querySelectorAll('.bullet').forEach(bullet => bullet.remove());

                gameContainer.innerHTML = '<div id="player"></div>';
                player = document.getElementById('player');
                player.style.left = `${playerX}px`;
                player.style.top = `${playerY}px`;
                
                starInterval = setInterval(createStar, 1000);
                bulletInterval = setInterval(() => {
                    shootBullet(playerX + playerSize / 2 - 4, playerY);
                }, 200);
                gameLoop();
            }

            function endGame() {
                isGameOver = true;
                clearInterval(starInterval);
                clearInterval(bulletInterval);
                cancelAnimationFrame(animationFrameId);
                showMessageBox(`انتهت اللعبة! نقاطك: ${score}`, 'العب مجدداً', startGame);
            }

            function createStar() {
                const star = document.createElement('div');
                star.className = 'star';
                star.textContent = '⭐';
                
                const currentStarHealth = 1 + Math.floor(score / 100);
                star.health = currentStarHealth;
                star.style.fontSize = `${24 + (currentStarHealth - 1) * 4}px`;
                
                const startX = Math.random() * (containerWidth - 24);
                star.style.left = `${startX}px`;
                star.style.top = `-24px`; 
                gameContainer.appendChild(star);
            }

            function shootBullet(startX, startY) {
                const bullet = document.createElement('div');
                bullet.className = 'bullet';
                bullet.style.left = `${startX}px`;
                bullet.style.top = `${startY}px`;
                gameContainer.appendChild(bullet);

                const bulletSpeed = 10;

                const moveBullet = () => {
                    if (isGameOver) {
                        bullet.remove();
                        return;
                    }
                    let currentY = parseFloat(bullet.style.top) - bulletSpeed;
                    bullet.style.top = `${currentY}px`;

                    const bulletRect = bullet.getBoundingClientRect();
                    const stars = document.querySelectorAll('.star');

                    let collisionDetected = false;
                    stars.forEach(star => {
                        const starRect = star.getBoundingClientRect();
                        if (bulletRect.bottom > starRect.top && bulletRect.top < starRect.bottom &&
                            bulletRect.right > starRect.left && bulletRect.left < starRect.right) {
                            
                            star.health--;
                            bullet.remove();
                            collisionDetected = true;

                            if (star.health <= 0) {
                                star.remove();
                                score++;
                                scoreDisplay.textContent = `النقاط: ${score}`;
                            } else {
                                star.style.opacity = '0.5';
                                setTimeout(() => { star.style.opacity = '1'; }, 100);
                            }
                        }
                    });

                    if (currentY > -10 && !collisionDetected) {
                        requestAnimationFrame(moveBullet);
                    } else if (currentY <= -10) {
                        bullet.remove();
                    }
                };
                requestAnimationFrame(moveBullet);
            }

            function gameLoop() {
                if (isGameOver) {
                    return;
                }

                const stars = document.querySelectorAll('.star');
                const starSpeed = 2 + Math.floor(score / 100) * 0.5;
                stars.forEach(star => {
                    let currentY = parseFloat(star.style.top) + starSpeed;
                    star.style.top = `${currentY}px`;

                    const starRect = star.getBoundingClientRect();
                    const playerRect = player.getBoundingClientRect();

                    if (starRect.bottom > playerRect.top && starRect.top < playerRect.bottom &&
                        starRect.right > playerRect.left && starRect.left < playerRect.right) {
                        endGame();
                    }

                    if (currentY > containerHeight) {
                        star.remove();
                    }
                });

                animationFrameId = requestAnimationFrame(gameLoop);
            }

            // Mouse events for movement
            gameContainer.addEventListener('mousemove', (e) => {
                if (!isGameOver) {
                    const rect = gameContainer.getBoundingClientRect();
                    playerX = e.clientX - rect.left - playerSize / 2;
                    playerY = e.clientY - rect.top - playerSize / 2;
                    playerX = Math.max(0, Math.min(playerX, containerWidth - playerSize));
                    playerY = Math.max(0, Math.min(playerY, containerHeight - playerSize));
                    player.style.left = `${playerX}px`;
                    player.style.top = `${playerY}px`;
                }
            });

            // Touch events for movement
            gameContainer.addEventListener('touchmove', (e) => {
                e.preventDefault();
                if (!isGameOver && e.touches.length > 0) {
                    const touch = e.touches[0];
                    const rect = gameContainer.getBoundingClientRect();
                    playerX = touch.clientX - rect.left - playerSize / 2;
                    playerY = touch.clientY - rect.top - playerSize / 2;
                    playerX = Math.max(0, Math.min(playerX, containerWidth - playerSize));
                    playerY = Math.max(0, Math.min(playerY, containerHeight - playerSize));
                    player.style.left = `${playerX}px`;
                    player.style.top = `${playerY}px`;
                }
            });
            
            showMessageBox('مستعد للعب؟', 'ابدأ اللعب', startGame);

            window.addEventListener('resize', () => {
                if (!isGameOver) {
                    location.reload();
                }
            });
        });
    </script>
</body>
</html>
