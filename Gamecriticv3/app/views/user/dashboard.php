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

            <!-- Most Anticipated Game Section -->
            <?php if ($mostAnticipatedGame): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #e31837, #c41230);">
                            <h5 class="mb-0">
                                <i class="fas fa-crown"></i> Most Anticipated Game
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="<?php echo htmlspecialchars($mostAnticipatedGame['game_picture']); ?>" 
                                         alt="<?php echo htmlspecialchars($mostAnticipatedGame['game_name']); ?>" 
                                         class="img-fluid rounded shadow" style="max-height: 200px; object-fit: cover;">
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-primary mb-2"><?php echo htmlspecialchars($mostAnticipatedGame['game_name']); ?></h3>
                                    <p class="text-muted mb-3">The community's most anticipated upcoming game!</p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success fs-6 me-3"><?php echo $mostAnticipatedGame['votes']; ?> votes</span>
                                        <span class="text-muted">Leading the poll</span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="text-center">
                                        <div class="display-4 text-primary">#1</div>
                                        <small class="text-muted">Most Voted</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Game Polls Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-poll"></i> Vote for Your Most Anticipated Game
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($pollGames)): ?>
                                <!-- No poll games -->
                                <div class="text-center py-4">
                                    <i class="fas fa-vote-yea fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No Poll Available</h6>
                                    <p class="text-muted">Check back later for new polls about upcoming games!</p>
                                </div>
                            <?php elseif ($hasVoted): ?>
                                <!-- User has already voted - show results -->
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> 
                                    <strong>Thank you for voting!</strong> You have already participated in this poll.
                                </div>
                                
                                <div class="poll-results">
                                    <h6 class="text-primary mb-3">Current Poll Results:</h6>
                                    <?php foreach ($pollStats as $index => $stat): ?>
                                        <div class="poll-option-result mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold">
                                                    #<?php echo $index + 1; ?> <?php echo htmlspecialchars($stat['game_name']); ?>
                                                </span>
                                                <span class="badge bg-primary"><?php echo $stat['votes']; ?> votes</span>
                                            </div>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar bg-info" style="width: <?php echo $stat['percentage']; ?>%">
                                                    <?php echo $stat['percentage']; ?>%
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            Total votes: <strong><?php echo array_sum(array_column($pollStats, 'votes')); ?></strong>
                                        </small>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- User hasn't voted yet - show voting options -->
                                <p class="text-muted mb-4">Which upcoming game are you most excited about? Choose one:</p>
                                
                                <form id="pollForm" class="poll-voting">
                                    <div class="row">
                                        <?php foreach ($pollGames as $index => $game): ?>
                                            <div class="col-md-4 mb-3">
                                                <div class="card poll-option-card h-100" style="cursor: pointer;" 
                                                     onclick="selectGame('<?php echo htmlspecialchars($game['game_name']); ?>')">
                                                    <div class="card-body text-center">
                                                        <img src="<?php echo htmlspecialchars($game['game_picture']); ?>" 
                                                             alt="<?php echo htmlspecialchars($game['game_name']); ?>" 
                                                             class="img-thumbnail mb-3" 
                                                             style="width: 120px; height: 120px; object-fit: cover;">
                                                        <h6 class="card-title"><?php echo htmlspecialchars($game['game_name']); ?></h6>
                                                        <div class="form-check">
                                                            <input type="radio" name="game_name" value="<?php echo htmlspecialchars($game['game_name']); ?>" 
                                                                   id="game_<?php echo $index; ?>" class="form-check-input">
                                                            <label class="form-check-label" for="game_<?php echo $index; ?>">
                                                                Vote for this game
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg" id="voteBtn" disabled>
                                            <i class="fas fa-vote-yea"></i> Cast My Vote
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Poll voting functionality
function selectGame(gameName) {
    // Uncheck all radio buttons
    document.querySelectorAll('input[name="game_name"]').forEach(radio => {
        radio.checked = false;
    });
    
    // Check the selected option
    const selectedRadio = document.querySelector(`input[value="${gameName}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
    }
    
    // Enable vote button
    document.getElementById('voteBtn').disabled = false;
    
    // Update visual selection
    document.querySelectorAll('.poll-option-card').forEach(card => {
        card.classList.remove('border-primary', 'bg-light');
    });
    
    // Highlight selected card
    event.currentTarget.classList.add('border-primary', 'bg-light');
}

// Handle poll form submission
document.getElementById('pollForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const voteBtn = document.getElementById('voteBtn');
    
    // Disable button and show loading
    voteBtn.disabled = true;
    voteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Voting...';
    
    fetch('<?php echo $baseUrl; ?>/poll/vote', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message and reload page to show results
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.innerHTML = `
                <i class="fas fa-check-circle"></i> ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card-body').insertBefore(alert, document.querySelector('.card-body').firstChild);
            
            // Reload page after a short delay to show results
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            // Show error message
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger alert-dismissible fade show';
            alert.innerHTML = `
                <i class="fas fa-exclamation-circle"></i> ${data.error}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card-body').insertBefore(alert, document.querySelector('.card-body').firstChild);
            
            // Re-enable button
            voteBtn.disabled = false;
            voteBtn.innerHTML = '<i class="fas fa-vote-yea"></i> Cast My Vote';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.innerHTML = `
            <i class="fas fa-exclamation-circle"></i> An error occurred. Please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.querySelector('.card-body').insertBefore(alert, document.querySelector('.card-body').firstChild);
        
        // Re-enable button
        voteBtn.disabled = false;
        voteBtn.innerHTML = '<i class="fas fa-vote-yea"></i> Cast My Vote';
    });
});
</script>

