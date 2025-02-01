<?php

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

// Verificar se a categoria foi passada
$category = isset($_GET['category']) ? $_GET['category'] : 'general';

// Validar Categoria
if (!in_array($category, $categories)) {
    echo 'Categoria inválida';
    exit;
}

// Redireciona para o Index se for a categoria 'general'
if ($category === 'general') {
    header('Location: index.php');
    exit;
}

// Chave da API
$apiKey = '0e6b4acbff474db3a4c349f3eb334019';

// URL base da API
$baseURL = 'https://newsapi.org/v2/top-headlines';
$url = "$baseURL?country=us&category=$category&apiKey=$apiKey";

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

// Definindo as notícias principais
$data = !empty($newsData['articles']) ? $newsData['articles'] : [];
$mainNews = array_slice($data, 0, 20, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsPost</title>
    <link rel="stylesheet" href="styles/category.css">
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
        <section class="trendingNews">
            <div class="categoryTitle">
                <h3><?php echo ucFirst($category); ?></h3>
                <h4>2025</h4>
            </div>

            <div class="newsContainer">
                <?php foreach ($mainNews as $news) : ?>
                    <div class="newsCard">
                        <h2><?php echo $news['source']['name'] ?></h2>

                        <div class="newsImage">
                            <?php if (!empty($news['urlToImage'])) : ?>
                                <img src="<?php echo $news['urlToImage']; ?>" alt="News Image">
                            <?php else : ?>
                                <img src="https://via.placeholder.com/150" alt="News Image">
                            <?php endif; ?>
                        </div>

                        <div class="newsContent">
                            <!-- Tira o portal original da notícia, removendo o que vem depois do -  -->
                            <?php $cleanTitle = preg_replace('/ - [^-]+$/', '', $news['title']) ?>
                            <h3><a href="<?php echo $news['url']; ?>"><?php echo $cleanTitle; ?></a></h3>
                            <p><?php echo $news['description']; ?></p>
                            <p><?php echo $news['publishedAt']; ?></p>

                            <!-- Verifica se existe um autor da notícia -->
                            <?php if (!empty($news['author'])) : ?>
                                <p><span>By </span><?php echo $news['author']; ?></p>
                            <?php else : ?>
                                <p><span>By </span>Unknown</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include 'HeaderAndFooter/footer.php'; ?>
</body>

</html>
