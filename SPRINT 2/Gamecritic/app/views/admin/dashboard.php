<?php
$content = ob_start();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-danger">🎮 Admin Dashboard</h1>
                <a href="<?php echo $baseUrl; ?>/admin/add-game" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add New Game
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Games</h5>
                            <h2 class="card-text"><?php echo $totalGames ?? 0; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <h2 class="card-text"><?php echo $totalUsers ?? 0; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Total Reviews</h5>
                            <h2 class="card-text"><?php echo $totalReviews ?? 0; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Admins</h5>
                            <h2 class="card-text"><?php echo $totalAdmins ?? 0; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Games Management -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Games Management</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($games)): ?>
                        <div class="alert alert-info">
                            No games found. <a href="<?php echo $baseUrl; ?>/admin/add-game" class="alert-link">Add your first game!</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Cover</th>
                                        <th>Name</th>
                                        <th>Genre</th>
                                        <th>Platform</th>
                                        <th>Release Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($games as $game): ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo $baseUrl; ?>/images/<?php echo htmlspecialchars($game['cover_image'] ?? 'default.jpg'); ?>" 
                                                     alt="<?php echo htmlspecialchars($game['name']); ?>" 
                                                     class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($game['name']); ?></strong>
                                                <br><small class="text-muted"><?php echo htmlspecialchars($game['description']); ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?php echo htmlspecialchars($game['genre']); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($game['platform']); ?></span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($game['release_date'])); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo $baseUrl; ?>/admin/edit-game/<?php echo $game['id']; ?>" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="deleteGame(<?php echo $game['id']; ?>, '<?php echo htmlspecialchars($game['name']); ?>')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<span id="gameName"></span>"?</p>
                <p class="text-warning">This action cannot be undone!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete Game</button>
            </div>
        </div>
    </div>
</div>

<script>
function deleteGame(gameId, gameName) {
    document.getElementById('gameName').textContent = gameName;
    document.getElementById('confirmDelete').onclick = function() {
        fetch(`<?php echo $baseUrl; ?>/admin/delete-game/${gameId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting game: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting game');
        });
    };
    
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
