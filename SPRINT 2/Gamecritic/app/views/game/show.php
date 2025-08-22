<?php
$title = htmlspecialchars($game['title']) . ' | GameCritic';
$content = ob_start();
?>

<div class="container mt-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <img src="<?php echo htmlspecialchars($game['cover_resolved']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($game['title']); ?>">
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-3">Community Score</h5>
                    <?php
                      $pos = isset($game['pos_count']) ? (int)$game['pos_count'] : (int)$aggregates['positive'];
                      $neg = isset($game['neg_count']) ? (int)$game['neg_count'] : (int)$aggregates['negative'];
                      $overall10 = isset($game['overall_score']) && $game['overall_score'] !== null && $game['overall_score'] !== ''
                        ? (float)$game['overall_score']
                        : (float)$aggregates['overall10'];
                    ?>
                    <div class="display-6 fw-bold text-white"><?php echo number_format($overall10, 1); ?>/10</div>
                    <div class="text-muted small">Score based on community votes</div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h1 class="mb-3"><?php echo htmlspecialchars($game['title']); ?></h1>
            <p class="mb-2">
                <span class="badge bg-primary me-2"><?php echo htmlspecialchars($game['genre']); ?></span>
                <span class="badge bg-secondary"><?php echo htmlspecialchars($game['platform']); ?></span>
            </p>
            <p class="text-muted mb-3">Released: <?php echo htmlspecialchars($game['release_year']); ?></p>
            <div class="mb-4">
                <h5>Description</h5>
                <p><?php echo nl2br(htmlspecialchars($game['description'])); ?></p>
            </div>
            <?php if (!empty($game['review'])): ?>
            <div class="mb-4">
                <h5>Our Review</h5>
                <p class="fst-italic"><?php echo nl2br(htmlspecialchars($game['review'])); ?></p>
            </div>
            <?php endif; ?>

            <div class="mb-4">
                <h5>Your Reaction</h5>
                <?php if ($currentUser): ?>
                    <?php 
                    $userVoteUp = $userVote && $userVote['rating'] >= 0.5;
                    $userVoteDown = $userVote && $userVote['rating'] < 0.5;
                    ?>
                    <form method="POST" action="<?php echo $baseUrl; ?>/game/<?php echo (int)$game['id']; ?>/thumb" class="d-inline">
                        <input type="hidden" name="type" value="up">
                        <button class="btn <?php echo $userVoteUp ? 'btn-success active' : 'btn-outline-success'; ?> me-2" type="submit">
                            👍 <?php echo $userVoteUp ? 'Voted Up' : 'Thumbs Up'; ?>
                        </button>
                    </form>
                    <form method="POST" action="<?php echo $baseUrl; ?>/game/<?php echo (int)$game['id']; ?>/thumb" class="d-inline">
                        <input type="hidden" name="type" value="down">
                        <button class="btn <?php echo $userVoteDown ? 'btn-danger active' : 'btn-outline-danger'; ?>" type="submit">
                            👎 <?php echo $userVoteDown ? 'Voted Down' : 'Thumbs Down'; ?>
                        </button>
                    </form>
                    <?php if ($userVote): ?>
                        <div class="mt-2">
                            <small class="text-muted">You can change your vote by clicking again</small>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-muted">
                        <a href="<?php echo $baseUrl; ?>/login">Login</a> to vote on this game
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <h5>Write a Comment</h5>
                <form method="POST" action="<?php echo $baseUrl; ?>/game/<?php echo (int)$game['id']; ?>/review">
                    <div class="mb-3">
                        <textarea class="form-control" name="comment" rows="3" placeholder="Share your thoughts..." required></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit Comment</button>
                </form>
            </div>

            <div class="mb-4">
                <h5>Recent Comments</h5>
                <?php if (empty($reviews)): ?>
                    <div class="text-muted">No comments yet. Be the first!</div>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($reviews as $rev): ?>
                            <?php if (empty($rev['comment'])) continue; ?>
                            <li class="list-group-item bg-transparent text-white">
                                <div class="d-flex justify-content-between">
                                    <strong><?php echo htmlspecialchars($rev['username'] ?? 'User'); ?></strong>
                                    <span class="text-muted small"><?php echo htmlspecialchars($rev['created_at']); ?></span>
                                </div>
                                <?php if (isset($rev['rating'])): ?>
                                    <div class="small text-muted">Rating: <?php echo number_format((float)$rev['rating'] * 10, 1); ?>/10</div>
                                <?php endif; ?>
                                <?php if (!empty($rev['comment'])): ?>
                                    <div><?php echo nl2br(htmlspecialchars($rev['comment'])); ?></div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <a href="<?php echo $baseUrl; ?>/" class="btn btn-outline-light">Back to Home</a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
