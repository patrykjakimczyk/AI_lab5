<?php

/** @var \App\Model\Announcement $announcement */
/** @var \App\Service\Router $router */

$title = 'Create Announcement';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Create Announcement</h1>
    <form action="<?= $router->generatePath('announcement-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_announcement-form.html.php'; ?>
        <input type="hidden" name="action" value="announcement-create">
    </form>

    <a href="<?= $router->generatePath('announcement-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
