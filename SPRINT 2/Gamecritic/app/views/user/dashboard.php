<?php
$content = ob_start();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-primary">🎮 Welcome, <?php echo htmlspecialchars($currentUser['name']); ?>!</h1>
                <div>
                    <a href="<?php echo $baseUrl; ?>/profile" class="btn btn-outline-primary me-2">
                        <i class="fas fa-user"></i> My Profile
                    </a>
                    <a href="<?php echo $baseUrl; ?>/logout" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>

            <!-- User Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">My Reviews</h5>
                            <h2 class="card-text"><?php echo $userReviews ?? 0; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Games Rated</h5>
                            <h2 class="card-text"><?php echo $gamesRated ?? 0; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Favorite Genre</h5>
                            <h2 class="card-text"><?php echo $favoriteGenre ?? 'N/A'; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="<?php echo $baseUrl; ?>/games" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-gamepad"></i><br>
                                        Browse Games
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="<?php echo $baseUrl; ?>/reviews" class="btn btn-outline-success w-100">
                                        <i class="fas fa-star"></i><br>
                                        My Reviews
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="<?php echo $baseUrl; ?>/recommendations" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-lightbulb"></i><br>
                                        Recommendations
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="<?php echo $baseUrl; ?>/polls" class="btn btn-outline-info w-100">
                                        <i class="fas fa-poll"></i><br>
                                        Game Polls
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Games -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Recent Games</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($recentGames)): ?>
                                <div class="alert alert-info">
                                    No games found. <a href="<?php echo $baseUrl; ?>/games" class="alert-link">Browse our game catalog!</a>
                                </div>
                            <?php else: ?>
                                <div class="row row-cols-2 row-cols-md-4 g-3">
                                    <?php foreach (array_slice($recentGames, 0, 8) as $game): ?>
                                        <div class="col">
                                            <a href="<?php echo $baseUrl; ?>/game/<?php echo $game['id']; ?>" class="text-decoration-none">
                                                <div class="card h-100 game-card">
                                                    <?php 
                                                      $cover = $game['cover_image'] ?? 'images/default.jpg';
                                                      if (strpos($cover, '/images/') === 0) {
                                                          $imgSrc = $baseUrl . $cover;
                                                      } elseif (strpos($cover, 'images/') === 0) {
                                                          $imgSrc = $baseUrl . '/' . $cover;
                                                      } else {
                                                          $imgSrc = htmlspecialchars($cover);
                                                      }
                                                    ?>
                                                    <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($game['title'] ?? ''); ?>">
                                                    <div class="card-body">
                                                        <h6 class="card-title text-white mb-1"><?php echo htmlspecialchars($game['title'] ?? ''); ?></h6>
                                                        <p class="meta mb-2">
                                                            <span class="badge bg-primary me-1"><?php echo htmlspecialchars($game['genre']); ?></span>
                                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($game['platform']); ?></span>
                                                        </p>
                                                        <button class="btn btn-sm btn-outline-primary">View Details</button>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
