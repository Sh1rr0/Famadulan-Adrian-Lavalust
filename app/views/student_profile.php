<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
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
            background: rgba(0, 0, 0, 0.50);
        }

        /* Content */
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 100px 20px 60px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }


        h1 {
            font-size: 24px;
            color: #fff;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .info-table tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 12px 10px;
            font-size: 15px;
            color: #fff;
        }

        .info-table td:first-child {
            font-weight: bold;
            color: #ccc;
            width: 170px;
        }

        .socials-title {
            font-size: 16px;
            font-weight: bold;
            color: #ccc;
            margin-bottom: 12px;
        }

        .socials-list {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .socials-list li a {
            display: inline-block;
            background-color: rgba(44, 62, 80, 0.8);
            color: #fff;
            padding: 8px 18px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: background-color 0.3s;
        }

        .socials-list li a:hover {
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
        <div class="card">

            <div class="header">
                <h1>Student Information</h1>
            </div>

            <table class="info-table">
                <tr>
                    <td>Student ID</td>
                    <td><?= $student_id; ?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?= $name; ?></td>
                </tr>
                <tr>
                    <td>Course</td>
                    <td><?= $course; ?></td>
                </tr>
                <tr>
                    <td>Year Level</td>
                    <td><?= $year; ?></td>
                </tr>
                <tr>
                    <td>Section</td>
                    <td><?= $section; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?= $email; ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><?= $address; ?></td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td><?= $ContactNumber; ?></td>
                </tr>
                <tr>
                    <td>Hobbies</td>
                    <td><?= $hobbies; ?></td>
                </tr>
            </table>

            <p class="socials-title">Social Media</p>
            <ul class="socials-list">
                <?php foreach ($social_media as $platform => $link): ?>
                    <li>
                        <a href="<?= $link; ?>" target="_blank">
                            <?= ucfirst($platform); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>

    <script>
        const vid1 = document.getElementById('vid1');
        const vid2 = document.getElementById('vid2');

        vid1.addEventListener('ended', () => {
            vid1.classList.add('hidden');
            vid2.classList.remove('hidden');
            vid2.currentTime = 0;
            vid2.play();
        });

        vid2.addEventListener('ended', () => {
            vid2.classList.add('hidden');
            vid1.classList.remove('hidden');
            vid1.currentTime = 10000;
            vid1.play();
        });
    </script>

</body>
</html>