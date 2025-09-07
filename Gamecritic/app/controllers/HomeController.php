<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/GameModel.php';

class HomeController extends BaseController {
    private $gameModel;

    public function __construct() {
        $this->gameModel = new GameModel();
    }

    public function index() {
        if (isset($_GET['__home']) && $_GET['__home'] === '1') {
            return 'home-ok';
        }
        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : "";
        $games = $this->gameModel->getGamesBySearch($searchQuery);
        $topRatedGames = $this->gameModel->getTopRatedGames(4);
        $currentUser = $this->getCurrentUser();

        return $this->render('home/index', [
            'games' => $games,
            'topRatedGames' => $topRatedGames,
            'currentUser' => $currentUser,
            'searchQuery' => $searchQuery
        ]);
    }

    public function search() {
        $term = isset($_GET['term']) ? trim($_GET['term']) : '';
        
        if (empty($term)) {
            $this->jsonResponse([]);
        }

        $games = $this->gameModel->searchGames($term);
        $this->jsonResponse($games);
    }

    public function filter() {
        $genre = isset($_GET['genre']) ? $_GET['genre'] : '';
        $platform = isset($_GET['platform']) ? $_GET['platform'] : '';
        
        if (!empty($genre)) {
            $games = $this->gameModel->getGamesByGenre($genre);
        } elseif (!empty($platform)) {
            $games = $this->gameModel->getGamesByPlatform($platform);
        } else {
            $games = $this->gameModel->findAll();
        }

        $currentUser = $this->getCurrentUser();
        
        return $this->render('home/index', [
            'games' => $games,
            'currentUser' => $currentUser,
            'filterGenre' => $genre,
            'filterPlatform' => $platform
        ]);
    }

    public function ping() {
        return 'ok';
    }
}
?>



