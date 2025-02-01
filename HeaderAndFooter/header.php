<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsPost</title>
    <link rel="stylesheet" href="styles/index.css">
    <script src="script/script.js" defer></script>
</head>

<body>
    <header>
        <div class="container">
            <h2>NewsPost</h2>
            <button class="menuBtn"><i class="fa-solid fa-bars"></i></button>
            <nav>
                <ul>
                    <?php foreach ($categories as $cat): ?>
                        <li><a href="category.php?category=<?= $cat; ?>"><?= ucfirst($cat) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
        <div class="menuDesktop">
            <nav>
                <ul>
                    <?php foreach ($categories as $cat): ?>
                        <li><a href="category.php?category=<?= $cat; ?>"><?= ucfirst($cat) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
        
</body>

</html>