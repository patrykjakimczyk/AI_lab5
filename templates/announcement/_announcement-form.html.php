<?php
    /** @var $announcement ?\App\Model\Announcement */
?>

<div class="form-group">
    <label for="subject">Title</label>
    <input type="text" id="subject" name="announcement[title]" value="<?= $announcement ? $announcement->getTitle() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="announcement[description]"><?= $announcement ? $announcement->getDescription() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
