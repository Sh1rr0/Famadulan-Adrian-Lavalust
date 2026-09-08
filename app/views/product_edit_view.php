<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
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
            background: rgba(0,0,0,0.50);
        }

        nav {
            background: rgba(44,62,80,0.85);
            padding: 15px 30px; position: fixed;
            width: 100%; top: 0; z-index: 100;
            backdrop-filter: blur(4px);
        }
        nav a {
            color: #fff; text-decoration: none;
            margin-right: 20px; font-size: 15px; font-weight: bold;
        }
        nav a:hover { color: #3498db; }

        .container {
            max-width: 600px; margin: 0 auto;
            padding: 100px 20px 60px;
        }

        .card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px; padding: 40px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        h1 {
            font-size: 22px; color: #fff;
            margin-bottom: 28px; text-align: center;
            text-shadow: 0 2px 6px rgba(0,0,0,0.4);
        }

        label {
            display: block; color: #ccc;
            font-size: 13px; margin-bottom: 6px; font-weight: bold;
        }

        input, textarea {
            width: 100%; padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: #fff; font-size: 14px;
            margin-bottom: 18px; outline: none;
            font-family: Arial, sans-serif;
        }

        textarea { resize: vertical; min-height: 80px; }

        .btn-row { display: flex; gap: 12px; }

        button {
            flex: 1; padding: 12px;
            border: none; border-radius: 6px;
            font-size: 15px; font-weight: bold;
            cursor: pointer; transition: background 0.3s;
        }

        .btn-submit { background: #3498db; color: #fff; }
        .btn-submit:hover { background: #2980b9; }
        .btn-cancel {
            background: rgba(44,62,80,0.8); color: #fff;
            text-decoration: none; text-align: center;
            display: flex; align-items: center;
            justify-content: center; border-radius: 6px;
            font-size: 15px; font-weight: bold;
            transition: background 0.3s;
        }
        .btn-cancel:hover { background: #e74c3c; }
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
        <a href="/products">← Back to Products</a>
    </nav>

    <div class="container">
        <div class="card">
            <h1>Edit Product</h1>

            <form method="POST" action="/products/update/<?= $product['id']; ?>">
                <label>Product Name</label>
                <input type="text" name="product_name"
                       value="<?= htmlspecialchars($product['product_name']); ?>" required>

                <label>Description</label>
                <textarea name="description"><?= htmlspecialchars($product['description']); ?></textarea>

                <label>Price (₱)</label>
                <input type="number" name="price" step="0.01"
                       value="<?= $product['price']; ?>" required>

                <label>Quantity</label>
                <input type="number" name="quantity"
                       value="<?= $product['quantity']; ?>" required>

                <div class="btn-row">
                    <button type="submit" class="btn-submit">Update Product</button>
                    <a href="/products" class="btn-cancel">Cancel</a>
                </div>
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