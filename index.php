<?php

// Chave da API
$apiKey = '0e6b4acbff474db3a4c349f3eb334019';

// URL base da API
$baseURL = 'https://newsapi.org/v2/top-headlines';
$url = "$baseURL?country=us&apiKey=$apiKey";

// Sessão por cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Adicionando um User-Agent genérico
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: NewsPost/1.0'
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Falha na requisição';
    curl_close($ch);
    exit;
}

curl_close($ch);

// Decodificando a resposta da API
$newsData = json_decode($response, true);
$data = !empty($newsData['articles']) ? $newsData['articles'] : [];

// Listar Categorias Válidas
$categories = [
    'general',
    'business',
    'entertainment',
    'health',
    'science',
    'sports',
    'technology',
];

// Notícia Principal
$mainNews = $data[0];

// As mais Lidas
$mostRead = array_slice($data, 1, 5, true);

// Notícias que pode gostar
$recommended = array_slice($data, 11, 5, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsPost</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="shortcut icon" href="N.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&family=Jaini&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/99d1235829.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php include 'HeaderAndFooter/header.php'; ?>

    <main>

        <!-- Seção da Notícia Principal -->
        <section class="mainNews">
            <div class="trending">
                <h3>Trending</h3>
                <h4>2025</h4>
            </div>
            <div class="news">
                <div class="newsImage">
                    <h2><?php echo $mainNews['source']['name'] ?></h2>
                    <?php if (!empty($mainNews['urlToImage'])) : ?>
                        <img src="<?php echo $mainNews['urlToImage'] ?>" alt="News Image">
                    <?php else : ?>
                        <img src="https://via.placeholder.com/150" alt="News Image">
                    <?php endif; ?>
                </div>
                <div class="newsContent">
                    <!-- Tira o portal original da notícia, removendo o que vem depois do -  -->
                    <?php $cleanTitle = preg_replace('/ - [^-]+$/', '', $mainNews['title']) ?>
                    <a href="<?php echo $mainNews['url'] ?>"><?php echo $cleanTitle ?></a>
                    <p><?php echo $mainNews['publishedAt'] ?></p>
                    <p><?php echo $mainNews['description'] ?></p>

                    <?php if (!empty($mainNews['author'])) : ?>
                        <p><span>By </span><?php echo $mainNews['author'] ?></p>
                    <?php else : ?>
                        <p><span>By </span>Unknown</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Seção das Notícias mais lidas -->
        <section class="mostRead">
            <h2>Most Read</h2>
            <?php foreach ($mostRead as $globalIndex => $news) : ?>
                <div class="mostReadNews">
                    <div class="mostReadContent">
                        <h2><?php echo $news['source']['name'] ?></h2>
                        <!-- Tira o portal original da notícia, removendo o que vem depois do -  -->
                        <?php $cleanTitle = preg_replace('/ - [^-]+$/', '', $news['title']) ?>
                        <a href="<?php echo $news['url'] ?>"><?php echo $cleanTitle ?></a>
                        <p><?php echo $news['publishedAt'] ?></p>
                        <?php if (!empty($news['author'])) : ?>
                            <p><span>By </span><?php echo $news['author'] ?></p>
                        <?php else : ?>
                            <p><span>By </span>Unknown</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- Seção de Notícias Recomendadas -->
        <section class="recommended">
            <h2>Recommended</h2>
            <?php foreach ($recommended as $globalIndex => $Rnews) : ?>
                <div class="recommendedNews">
                    <div class="recommendedImage">
                        <?php if (!empty($Rnews['urlToImage'])) : ?>
                            <img src="<?php echo $Rnews['urlToImage'] ?>" alt="News Image">
                        <?php else : ?>
                            <img src="https://via.placeholder.com/150" alt="News Image">
                        <?php endif; ?>
                    </div>
                    <div class="recommendedContent">
                        <h2><?php echo $Rnews['source']['name'] ?></h2>
                        <!-- Tira o portal original da notícia, removendo o que vem depois do -  -->
                        <?php $cleanTitle = preg_replace('/ - [^-]+$/', '', $Rnews['title']) ?>
                        <a href="<?php echo $Rnews['url'] ?>"><?php echo $cleanTitle ?></a>
                        <p><?php echo $Rnews['publishedAt'] ?></p>
                        <?php if (!empty($Rnews['author'])) : ?>
                            <p><span>By </span><?php echo $Rnews['author'] ?></p>
                        <?php else : ?>
                            <p><span>By </span>Unknown</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <?php include 'HeaderAndFooter/footer.php'; ?>

    </main>

</body>

</html>
