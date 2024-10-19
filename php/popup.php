<?php
if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
    $message = $_SESSION['success'];
    $type = 'success'; // Classe CSS pour un succès
    $_SESSION['success'] = ''; // Réinitialisation
} elseif (isset($_SESSION['error']) && $_SESSION['error'] != '') {
    $message = $_SESSION['error'];
    $type = 'error'; // Classe CSS pour une erreur
    $_SESSION['error'] = ''; // Réinitialisation
} else {
    $message = '';
    $type = ''; // Pas de message à afficher
}
?>

<?php if ($message != ''): ?>
    <div id="popupMessage" class="popup <?php echo $type; ?>">
        <p><?php echo htmlspecialchars($message); ?></p>
    </div>
<?php endif; ?>
