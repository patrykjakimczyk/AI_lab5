<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Announcement;
use App\Service\Router;
use App\Service\Templating;

class AnnouncementController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $announcements = Announcement::findAll();
        $html = $templating->render('announcement/index.html.php', [
            'announcements' => $announcements,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestAnnouncement, Templating $templating, Router $router): ?string
    {
        if ($requestAnnouncement) {
            $announcement = Announcement::fromArray($requestAnnouncement);
            // @todo missing validation
            $announcement->save();

            $path = $router->generatePath('announcement-index');
            $router->redirect($path);
            return null;
        } else {
            $announcement = new Announcement();
        }

        $html = $templating->render('announcement/create.html.php', [
            'announcement' => $announcement,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $announcementId, ?array $requestAnnouncement, Templating $templating, Router $router): ?string
    {
        $announcement = Announcement::find($announcementId);
        echo ! $announcement;
        if (! $announcement) {
            throw new NotFoundException("Missing announcement with id $announcementId");
        }

        if ($requestAnnouncement) {
            $announcement->fill($requestAnnouncement);
            // @todo missing validation
            $announcement->save();

            $path = $router->generatePath('announcement-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('announcement/edit.html.php', [
            'announcement' => $announcement,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $announcementId, Templating $templating, Router $router): ?string
    {
        $announcement = Announcement::find($announcementId);
        if (! $announcement) {
            throw new NotFoundException("Missing post with id $announcementId");
        }

        $html = $templating->render('announcement/show.html.php', [
            'announcement' => $announcement,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $announcementId, Router $router): ?string
    {
        $announcement = Announcement::find($announcementId);
        if (! $announcement) {
            throw new NotFoundException("Missing post with id $announcementId");
        }

        $announcement->delete();
        $path = $router->generatePath('announcement-index');
        $router->redirect($path);
        return null;
    }
}
