<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            min-height: 100vh;
        }

        nav {
            background-color: rgba(44, 62, 80, 0.85);
            padding: 15px 30px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(4px);
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            font-size: 15px;
            font-weight: bold;
        }

        nav a:hover {
            color: #3498db;
        }

        /* Video Background */
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .video-bg video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            transition: opacity 1s ease;
        }

        .video-bg video.hidden {
            opacity: 0;
        }

        .video-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
        }

        /* Content */
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding-top: 180px;
            text-align: center;
        }

    

        h1 {
            font-size: 32px;
            color: #fff;
            margin-bottom: 10px;
            text-shadow: 0 2px 6px rgba(0,0,0,0.5);
        }

        h3 {
            font-size: 16px;
            color: #ddd;
            font-weight: normal;
            margin-bottom: 30px;
            text-shadow: 0 1px 4px rgba(0,0,0,0.4);
        }

        .btn {
            display: inline-block;
            background-color: #2c3e50;
            color: #fff;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.3s;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>

    <!-- Video Background -->
    <div class="video-bg">
        <video id="vid1" autoplay muted playsinline>
            <source src="https://p3re.jp/resources/img/top/fv_movie1_bef3ec38c6b4ba869207fc85cf95bc78.mp4" type="video/mp4">
        </video>
        <video id="vid2" autoplay muted playsinline class="hidden">
            <source src="https://p3re.jp/resources/img/top/fv_movie2_1aaf21a0de60678450744da0dbaf9ef4.mp4" type="video/mp4">
        </video>
    </div>

    <nav>
        <a href="/student">Home</a>
    </nav>

    <div class="container">
        <h1>Student Home Page</h1>
        <h3>Welcome!!</h3>
        <a href="/student/profile" class="btn">View My Profile</a>
    </div>

    <script>
        const vid1 = document.getElementById('vid1');
        const vid2 = document.getElementById('vid2');

        // When video 1 ends, switch to video 2
        vid1.addEventListener('ended', () => {
            vid1.classList.add('hidden');
            vid2.classList.remove('hidden');
            vid2.currentTime = 0;
            vid2.play();
        });

        // When video 2 ends, switch back to video 1
        vid2.addEventListener('ended', () => {
            vid2.classList.add('hidden');
            vid1.classList.remove('hidden');
            vid1.currentTime = 10000;
            vid1.play();
        });
    </script>

</body>
</html>