<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Ganti asset('css/styles.css') dengan path sesuai dengan lokasi file CSS Anda -->
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to Our Website</h1>
            <p>This is a simple landing page.</p>
        </header>
        <main>
            <section class="features">
            <a href="http://192.168.61.34/esd" class="btn">ESD Portal</a>
            <a href="http://192.168.61.34/stock" class="btn">Stock Portal</a>
            <a href="http://192.168.61.34/utility" class="btn">Utility Portal</a>
                <h2>Features</h2>
                <ul>
                    <li>Feature 1</li>
                    <li>Feature 2</li>
                    <li>Feature 3</li>
                </ul>
            </section>
            <section class="cta">
                <h2>Call to Action</h2>
                <p>Sign up now!</p>
                <a href="#" class="btn">Sign Up</a>
            </section>
        </main>
        <footer>
            <p>&copy; 2024 Your Company</p>
        </footer>
    </div>
</body>
</html>
