<?php
$title = 'Dashboard | GameCritic';
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
                <div class="col-md-6">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">My Reviews</h5>
                            <h2 class="card-text"><?php echo $userReviews ?? 0; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
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
                                <div class="col-md-4 mb-3">
                                    <a href="<?php echo $baseUrl; ?>/" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-gamepad"></i><br>
                                        Browse Games
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="<?php echo $baseUrl; ?>/my-reviews" class="btn btn-outline-success w-100">
                                        <i class="fas fa-star"></i><br>
                                        My Reviews
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="<?php echo $baseUrl; ?>/recommendations" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-lightbulb"></i><br>
                                        Recommendations
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Things You May Like -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #e31837, #c41230);">
                            <h5 class="mb-0">
                                <i class="fas fa-heart"></i> Things You May Like
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($games)): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No games available yet. <a href="<?php echo $baseUrl; ?>/" class="alert-link">Check out our game catalog!</a>
                                </div>
                            <?php else: ?>
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                    <?php foreach (array_slice($games, 0, 6) as $game): ?>
                                        <div class="col">
                                            <a href="<?php echo $baseUrl; ?>/game/<?php echo $game['id']; ?>" class="text-decoration-none">
                                                <div class="card h-100 game-card shadow-sm">
                                                    <?php 
                                                      $cover = $game['cover_image'] ?? '/images/default.jpg';
                                                      if (strpos($cover, '/images/') === 0) {
                                                          $imgSrc = $baseUrl . $cover;
                                                      } elseif (strpos($cover, 'images/') === 0) {
                                                          $imgSrc = $baseUrl . '/' . $cover;
                                                      } else {
                                                          $imgSrc = $baseUrl . '/images/' . $cover;
                                                      }
                                                    ?>
                                                    <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($game['title'] ?? ''); ?>" style="height: 200px; object-fit: cover;">
                                                    <div class="card-body d-flex flex-column">
                                                        <h6 class="card-title text-white mb-2"><?php echo htmlspecialchars($game['title'] ?? ''); ?></h6>
                                                        <p class="card-text text-muted small flex-grow-1"><?php echo htmlspecialchars(substr($game['description'] ?? 'No description available', 0, 80)) . '...'; ?></p>
                                                        <div class="mt-auto">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <span class="badge bg-primary"><?php echo htmlspecialchars($game['genre'] ?? 'N/A'); ?></span>
                                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($game['platform'] ?? 'N/A'); ?></span>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <small class="text-muted"><?php echo $game['release_year'] ?? 'N/A'; ?></small>
                                                                <div class="rating-badge">
                                                                    <span class="badge bg-success"><?php echo number_format($game['overall_score'] ?? 0, 1); ?>/10</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- View More Games Button -->
                                <div class="text-center mt-4">
                                    <a href="<?php echo $baseUrl; ?>/" class="btn btn-outline-primary">
                                        <i class="fas fa-gamepad"></i> View All Games
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Game Polls Section (Placeholder for future) -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-poll"></i> Game Polls
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="py-4">
                                <i class="fas fa-vote-yea fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">Game Polls Coming Soon!</h6>
                                <p class="text-muted">Participate in polls about your favorite games and share your opinions with the community.</p>
                                <button class="btn btn-outline-info" disabled>
                                    <i class="fas fa-clock"></i> Coming Soon
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

