<?php

/** @var \App\Model\Announcement $announcement */
/** @var \App\Service\Router $router */

$title = "{$announcement->getTitle()} ({$announcement->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $announcement->getTitle() ?></h1>
    <article>
        <?= $announcement->getDescription();?>
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('announcement-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('announcement-edit', ['id'=> $announcement->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
