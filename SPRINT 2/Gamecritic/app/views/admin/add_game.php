<?php
$content = ob_start();
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus"></i> Add New Game
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo $baseUrl; ?>/admin/add-game" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Game Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Genre *</label>
                                    <select class="form-select" id="genre" name="genre" required>
                                        <option value="">Select Genre</option>
                                        <option value="action" <?php echo ($formData['genre'] ?? '') === 'action' ? 'selected' : ''; ?>>Action</option>
                                        <option value="adventure" <?php echo ($formData['genre'] ?? '') === 'adventure' ? 'selected' : ''; ?>>Adventure</option>
                                        <option value="rpg" <?php echo ($formData['genre'] ?? '') === 'rpg' ? 'selected' : ''; ?>>RPG</option>
                                        <option value="strategy" <?php echo ($formData['genre'] ?? '') === 'strategy' ? 'selected' : ''; ?>>Strategy</option>
                                        <option value="sports" <?php echo ($formData['genre'] ?? '') === 'sports' ? 'selected' : ''; ?>>Sports</option>
                                        <option value="racing" <?php echo ($formData['genre'] ?? '') === 'racing' ? 'selected' : ''; ?>>Racing</option>
                                        <option value="puzzle" <?php echo ($formData['genre'] ?? '') === 'puzzle' ? 'selected' : ''; ?>>Puzzle</option>
                                        <option value="simulation" <?php echo ($formData['genre'] ?? '') === 'simulation' ? 'selected' : ''; ?>>Simulation</option>
                                        <option value="horror" <?php echo ($formData['genre'] ?? '') === 'horror' ? 'selected' : ''; ?>>Horror</option>
                                        <option value="indie" <?php echo ($formData['genre'] ?? '') === 'indie' ? 'selected' : ''; ?>>Indie</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="platform" class="form-label">Platform *</label>
                                    <select class="form-select" id="platform" name="platform" required>
                                        <option value="">Select Platform</option>
                                        <option value="pc" <?php echo ($formData['platform'] ?? '') === 'pc' ? 'selected' : ''; ?>>PC</option>
                                        <option value="ps5" <?php echo ($formData['platform'] ?? '') === 'ps5' ? 'selected' : ''; ?>>PlayStation 5</option>
                                        <option value="ps4" <?php echo ($formData['platform'] ?? '') === 'ps4' ? 'selected' : ''; ?>>PlayStation 4</option>
                                        <option value="xbox-series-x" <?php echo ($formData['platform'] ?? '') === 'xbox-series-x' ? 'selected' : ''; ?>>Xbox Series X</option>
                                        <option value="xbox-one" <?php echo ($formData['platform'] ?? '') === 'xbox-one' ? 'selected' : ''; ?>>Xbox One</option>
                                        <option value="nintendo-switch" <?php echo ($formData['platform'] ?? '') === 'nintendo-switch' ? 'selected' : ''; ?>>Nintendo Switch</option>
                                        <option value="mobile" <?php echo ($formData['platform'] ?? '') === 'mobile' ? 'selected' : ''; ?>>Mobile</option>
                                        <option value="multi-platform" <?php echo ($formData['platform'] ?? '') === 'multi-platform' ? 'selected' : ''; ?>>Multi-Platform</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="release_date" class="form-label">Release Date *</label>
                                    <input type="date" class="form-control" id="release_date" name="release_date" 
                                           value="<?php echo $formData['release_date'] ?? ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Game Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="Describe the game, its features, gameplay, etc." required><?php echo htmlspecialchars($formData['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Cover Image</label>
                            <input type="file" class="form-control" id="cover_image" name="cover_image" 
                                   accept="image/*">
                            <div class="form-text">Upload a cover image (JPG, PNG, GIF). Max size: 5MB</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="developer" class="form-label">Developer</label>
                                    <input type="text" class="form-control" id="developer" name="developer" 
                                           value="<?php echo htmlspecialchars($formData['developer'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="publisher" class="form-label">Publisher</label>
                                    <input type="text" class="form-control" id="publisher" name="publisher" 
                                           value="<?php echo htmlspecialchars($formData['publisher'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">ESRB Rating</label>
                                    <select class="form-select" id="rating" name="rating">
                                        <option value="">Select Rating</option>
                                        <option value="E" <?php echo ($formData['rating'] ?? '') === 'E' ? 'selected' : ''; ?>>E - Everyone</option>
                                        <option value="E10+" <?php echo ($formData['rating'] ?? '') === 'E10+' ? 'selected' : ''; ?>>E10+ - Everyone 10+</option>
                                        <option value="T" <?php echo ($formData['rating'] ?? '') === 'T' ? 'selected' : ''; ?>>T - Teen</option>
                                        <option value="M" <?php echo ($formData['rating'] ?? '') === 'M' ? 'selected' : ''; ?>>M - Mature</option>
                                        <option value="AO" <?php echo ($formData['rating'] ?? '') === 'AO' ? 'selected' : ''; ?>>AO - Adults Only</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price ($)</label>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           step="0.01" min="0" 
                                           value="<?php echo $formData['price'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo $baseUrl; ?>/admin/dashboard" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Add Game
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
