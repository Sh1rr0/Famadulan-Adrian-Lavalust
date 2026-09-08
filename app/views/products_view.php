<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #333; min-height: 100vh; }

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
            background: rgba(0,0,0,0.50);
        }

        nav {
            background: rgba(44,62,80,0.85);
            padding: 15px 30px; position: fixed;
            width: 100%; top: 0; z-index: 100;
            backdrop-filter: blur(4px);
            display: flex; justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: #fff; text-decoration: none;
            margin-right: 20px; font-size: 15px; font-weight: bold;
        }
        nav a:hover { color: #3498db; }
        .nav-right { color: #ccc; font-size: 14px; }
        .nav-right a { color: #e74c3c; margin-left: 16px; }

        .container {
            max-width: 1000px; margin: 0 auto;
            padding: 100px 20px 60px;
        }

        .card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px; padding: 40px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        .card-header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 28px;
        }

        h1 { font-size: 24px; color: #fff;
             text-shadow: 0 2px 6px rgba(0,0,0,0.4); }

        .btn {
            display: inline-block; padding: 8px 20px;
            border-radius: 6px; text-decoration: none;
            font-size: 14px; font-weight: bold;
            transition: background 0.3s; cursor: pointer;
            border: none;
        }
        .btn-add  { background: #27ae60; color: #fff; }
        .btn-add:hover { background: #2ecc71; }
        .btn-edit { background: rgba(52,152,219,0.8); color: #fff; }
        .btn-edit:hover { background: #3498db; }
        .btn-del  { background: rgba(231,76,60,0.8); color: #fff; }
        .btn-del:hover { background: #e74c3c; }

        table { width: 100%; border-collapse: collapse; }

        thead tr { border-bottom: 2px solid rgba(255,255,255,0.3); }
        thead th {
            padding: 12px 10px; text-align: left;
            font-size: 13px; color: #ccc;
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.10);
            transition: background 0.2s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,0.08); }
        tbody td { padding: 12px 10px; font-size: 14px; color: #fff; }

        .badge {
            display: inline-block;
            background: rgba(44,62,80,0.8);
            color: #fff; border-radius: 12px;
            padding: 2px 10px; font-size: 12px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .actions { display: flex; gap: 8px; }
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

    <nav>
        <div>
            <a href="/student">Home</a>
            <a href="/student/profile">Profile</a>
            <a href="/users">Users</a>
            <a href="/products">Products</a>
        </div>
        <div class="nav-right">
            Welcome, <?= htmlspecialchars($username); ?>
            <a href="/logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Product Management</h1>
                <a href="/products/create" class="btn btn-add">+ Add Product</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><span class="badge"><?= $product['id']; ?></span></td>
                        <td><?= htmlspecialchars($product['product_name']); ?></td>
                        <td><?= htmlspecialchars($product['description']); ?></td>
                        <td>₱<?= number_format($product['price'], 2); ?></td>
                        <td><?= $product['quantity']; ?></td>
                        <td><?= $product['created_at']; ?></td>
                        <td>
                            <div class="actions">
                                <a href="/products/edit/<?= $product['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="/products/delete/<?= $product['id']; ?>" class="btn btn-del"
                                   onclick="return confirm('Delete this product?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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