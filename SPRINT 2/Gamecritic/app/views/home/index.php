<?php
$title = 'GameCritic – Discover Games';
$content = ob_start();
?>

<!-- Featured Games Carousel -->
<div id="featuredGames" class="carousel slide mt-3" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?php echo $baseUrl; ?>/images/godofwar.jpg" class="d-block w-100 carousel-img" alt="God of War">
            <div class="carousel-caption d-none d-md-block">
                <h5>God of War: Ragnarök</h5>
                <p>Rated 9.8 – Epic Norse adventure continues</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?php echo $baseUrl; ?>/images/eldenring.jpg" class="d-block w-100 carousel-img" alt="Elden Ring">
            <div class="carousel-caption d-none d-md-block">
                <h5>Elden Ring</h5>
                <p>FromSoftware's masterpiece of exploration</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?php echo $baseUrl; ?>/images/zelda.jpg" class="d-block w-100 carousel-img" alt="Zelda">
            <div class="carousel-caption d-none d-md-block">
                <h5>Zelda: Tears of the Kingdom</h5>
                <p>A magical return to Hyrule</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#featuredGames" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#featuredGames" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Top Rated Games -->
<?php if (!empty($topRatedGames)): ?>
<div class="container mt-5">
    <h2 class="mb-4">Top Rated Games</h2>
    <div class="row row-cols-1 row-cols-md-4 g-3">
        <?php foreach ($topRatedGames as $game): ?>
        <div class="col">
            <a href="<?php echo $baseUrl; ?>/game/<?php echo (int)$game['id']; ?>" class="text-decoration-none">
                <div class="card h-100 game-card">
                    <img src="<?php echo htmlspecialchars($game['cover_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($game['title']); ?>">
                    <div class="card-body">
                        <h5 class="card-title text-white"><?php echo htmlspecialchars($game['title']); ?></h5>
                        <p class="meta mb-2">
                            <span class="badge bg-primary me-1"><?php echo htmlspecialchars($game['genre']); ?></span>
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($game['platform']); ?></span>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="rating-badge">
                                <span class="badge bg-success fs-6"><?php echo number_format($game['overall_score'], 1); ?>/10</span>
                            </div>
                            <small class="text-muted">
                                <?php echo (int)$game['pos_count']; ?> 👍 <?php echo (int)$game['neg_count']; ?> 👎
                            </small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- All Games -->
<div class="container mt-5">
    <h2 class="mb-4">All Games</h2>
    
    <!-- Search Results Info -->
    <?php if (!empty($searchQuery)): ?>
        <div class="alert alert-info">
            Search results for: "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"
            <a href="/" class="float-end">Clear Search</a>
        </div>
    <?php endif; ?>
    
    <!-- Filter Info -->
    <?php if (isset($filterGenre) || isset($filterPlatform)): ?>
        <div class="alert alert-info">
            Filtered by: 
            <?php if (isset($filterGenre)): ?>
                <strong>Genre: <?php echo htmlspecialchars($filterGenre); ?></strong>
            <?php endif; ?>
            <?php if (isset($filterPlatform)): ?>
                <strong>Platform: <?php echo htmlspecialchars($filterPlatform); ?></strong>
            <?php endif; ?>
            <a href="/" class="float-end">Clear Filters</a>
        </div>
    <?php endif; ?>
    
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($games)): ?>
            <?php foreach ($games as $game): ?>
            <div class="col">
                <a href="<?php echo $baseUrl; ?>/game/<?php echo (int)$game['id']; ?>" class="text-decoration-none">
                    <div class="card h-100 game-card">
                        <img src="<?php echo htmlspecialchars($game['cover_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($game['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-white"><?php echo htmlspecialchars($game['title']); ?></h5>
                            <p class="meta mb-2">
                                <span class="badge bg-primary me-1"><?php echo htmlspecialchars($game['genre']); ?></span>
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($game['platform']); ?></span>
                            </p>
                            <p class="card-text text-truncate"><?php echo htmlspecialchars($game['description']); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <h4>No games found</h4>
                    <p>Try adjusting your search criteria or browse all games.</p>
                    <a href="/" class="btn btn-primary">View All Games</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>


