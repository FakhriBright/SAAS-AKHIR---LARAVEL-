<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7fe; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-card { background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 3rem; text-align: center; max-width: 500px; }
        .error-code { font-size: 5rem; font-weight: 700; color: #2d6a4f; line-height: 1; }
        .error-msg { font-size: 1.2rem; color: #666; margin: 1rem 0 2rem; }
        .btn-home { background: #2d6a4f; color: white; border: none; padding: 0.8rem 2rem; border-radius: 50px; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn-home:hover { background: #1b4332; color: white; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">404</div>
        <h3 class="fw-bold mb-3">Halaman Tidak Ditemukan</h3>
        <p class="error-msg">Maaf, halaman yang kamu cari tidak ada atau sudah dipindahkan.</p>
        <a href="<?php echo e(route('home')); ?>" class="btn-home">
            <i class="bi bi-house me-2"></i>Kembali ke Beranda
        </a>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\saas-akhir\resources\views/errors/404.blade.php ENDPATH**/ ?>