<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; min-height: 100vh; }

        .video-bg {
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1; overflow: hidden;
        }
        .video-bg video {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%; min-height: 100%;
            object-fit: cover; transition: opacity 1s ease;
        }
        .video-bg video.hidden { opacity: 0; }
        .video-bg::after {
            content: ''; position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.55);
        }

        .container {
            display: flex; justify-content: center;
            align-items: center; min-height: 100vh;
            padding: 20px;
        }

        .card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px; padding: 40px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            width: 100%; max-width: 380px;
        }

        h1 {
            text-align: center; color: #fff;
            margin-bottom: 28px; font-size: 22px;
            text-shadow: 0 2px 6px rgba(0,0,0,0.4);
        }

        .error {
            background: rgba(231,76,60,0.3);
            color: #fff; padding: 10px;
            border-radius: 6px; margin-bottom: 16px;
            text-align: center; font-size: 14px;
        }

        label {
            display: block; color: #ccc;
            font-size: 13px; margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%; padding: 10px 14px;
            border-radius: 6px; border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: #fff; font-size: 14px;
            margin-bottom: 18px; outline: none;
        }

        input::placeholder { color: #aaa; }

        button {
            width: 100%; padding: 12px;
            background: #2c3e50; color: #fff;
            border: none; border-radius: 6px;
            font-size: 15px; font-weight: bold;
            cursor: pointer; transition: background 0.3s;
        }

        button:hover { background: #3498db; }
    </style>
</head>
<body>

    <div class="video-bg">
        <video id="vid1" autoplay muted playsinline>
            <source src="https://p3re.jp/resources/img/top/fv_movie1_bef3ec38c6b4ba869207fc85cf95bc78.mp4" type="video/mp4">
        </video>
        <video id="vid2" autoplay muted playsinline class="hidden">
            <source src="https://p3re.jp/resources/img/top/fv_movie2_1aaf21a0de60678450744da0dbaf9ef4.mp4" type="video/mp4">
        </video>
    </div>

    <div class="container">
        <div class="card">
            <h1>Login</h1>

            <?php if (isset($_GET['error'])): ?>
                <div class="error">Invalid username or password.</div>
            <?php endif; ?>

            <form method="POST" action="/login">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
        const vid1 = document.getElementById('vid1');
        const vid2 = document.getElementById('vid2');
        vid1.addEventListener('ended', () => {
            vid1.classList.add('hidden');
            vid2.classList.remove('hidden');
            vid2.currentTime = 0; vid2.play();
        });
        vid2.addEventListener('ended', () => {
            vid2.classList.add('hidden');
            vid1.classList.remove('hidden');
            vid1.currentTime = 0; vid1.play();
        });
    </script>
</body>
</html>