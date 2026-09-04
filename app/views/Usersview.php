<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
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
            max-width: 900px;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        }

        thead th {
            padding: 12px 10px;
            text-align: left;
            font-size: 14px;
            color: #ccc;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.10);
            transition: background-color 0.2s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.08);
        }

        tbody td {
            padding: 12px 10px;
            font-size: 15px;
            color: #fff;
        }

        .badge {
            display: inline-block;
            background-color: rgba(44, 62, 80, 0.8);
            color: #fff;
            border-radius: 12px;
            padding: 2px 10px;
            font-size: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        <a href="/student/profile">Student Profile</a>
        <a href="/users">Users</a>
    </nav>

    <div class="container">
        <div class="card">

            <div class="header">
                <h1>User Management</h1>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><span class="badge"><?= $user['id']; ?></span></td>
                        <td><?= $user['firstname']; ?></td>
                        <td><?= $user['lastname']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['username']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

    <script>
       
         // 1. Grab references to BOTH video elements
    const vid1 = document.getElementById('vid1');
    const vid2 = document.getElementById('vid2');

    // 2. Hide vid1 immediately and make sure vid2 is visible and playing
    vid1.classList.add('hidden');
    vid1.pause(); 
    
    vid2.classList.remove('hidden');
    vid2.currentTime = 0;
    vid2.play().catch(err => console.log("Autoplay blocked, user interaction required:", err));

    // 3. When vid2 ends, loop it back to the beginning seamlessly
    vid2.addEventListener('ended', () => {
        vid2.currentTime = 0;
        vid2.play();
    });
    </script>

</body>
</html>