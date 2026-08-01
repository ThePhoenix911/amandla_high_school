<?php include __DIR__ . '/../view/header.php'; ?>

<main>
    <div style="text-align: center; max-width: 600px; padding: 2rem;">
        <h1 style="color: #d9534f; margin-bottom: 1rem;">Database Error</h1>
        <p style="color: #666; margin-bottom: 1.5rem;">Error: <?php if(isset($error_message)) echo htmlspecialchars($error_message); ?></p>
        <a href="/" class="btnSubmit" style="display: inline-block; text-decoration: none; width: auto; padding: 0.75rem 2rem;"><i class="fa-solid fa-house"></i> Return to Main Page</a>
    </div>
</main>

<?php include __DIR__ . '/../view/footer.php'; ?>
