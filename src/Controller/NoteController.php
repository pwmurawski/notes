<?php
declare(strict_types=1);

namespace App\Controller;

require_once('src\Controller\AbstractController.php');
require_once('src\Exception\NotFoundException.php');

use App\Exception\NotFoundException;

class NoteController extends AbstractController {
    private const PAGE_SIZE = 10;

    protected function createAction(): void {
        if ($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description'),
            ];

            $this->noteModel->create($noteData);
            $this->redirect('/', ['before' => 'created']);
        }

        $this->view->render('create');
    }

    protected function showAction(): void {
        $this->view->render('show', ['noteData' => $this->getNote()]);
    }

    protected function listAction(): void {
        $phrase = $this->request->getParam('phrase');
        $before = $this->request->getParam('before');
        $error = $this->request->getParam('error');
        $page = [
            'currentPage' => (int) $this->request->getParam('page', 1),
            'size' => (int) $this->request->getParam('pagesize', self::PAGE_SIZE),
        ];
        $sort = [
            'by' => $this->request->getParam('sortBy', 'created'),
            'order' => $this->request->getParam('sortOrder', 'asc'),
        ];

        if(!in_array($page['size'], [1, 5, 10, 25])) {
            $page['size'] = self::PAGE_SIZE;
        }

        $notes = $this->noteModel->list($page, $sort, $phrase);
        $numberNotes = (int) $this->noteModel->count($phrase);

        $page['pages'] = (int) ceil($numberNotes / $page['size']);
        
        $this->view->render(
            'list', 
            [
                'phrase' => $phrase,
                'page' => $page,
                'sort' => $sort,
                'notes' => $notes,
                'before' => $before,
                'error' => $error,
            ],
        );
    }

    protected function editAction(): void {
        if($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $newNoteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description'),
            ];

            $this->noteModel->edit($noteId, $newNoteData);
            $this->redirect('/', ['before' => 'edited']);
        }        

        $this->view->render('edit', ['noteData' => $this->getNote()]);
    }

    protected function deleteAction(): void {
        if($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');

            $this->noteModel->delete($noteId);
            $this->redirect('/', ['before' => 'deleted']);
        }

        $this->view->render('delete', ['noteData' => $this->getNote()]);
    }

    private function getNote(): array {
        $noteId = (int) $this->request->getParam('id');
        if(!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }
        
        return $this->noteModel->get($noteId);
    }
}