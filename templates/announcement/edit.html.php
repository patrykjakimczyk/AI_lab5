<?php

/** @var \App\Model\Announcement $announcement */
/** @var \App\Service\Router $router */

$title = "Edit Announcement {$announcement->getTitle()} ({$announcement->getId()})";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('announcement-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_announcement-form.html.php'; ?>
        <input type="hidden" name="action" value="announcement-edit">
        <input type="hidden" name="id" value="<?= $announcement->getId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('announcement-index') ?>">Back to list</a></li>
        <li>
            <form action="<?= $router->generatePath('announcement-delete') ?>" method="post">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                <input type="hidden" name="action" value="announcement-delete">
                <input type="hidden" name="id" value="<?= $announcement->getId() ?>">
            </form>
        </li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
