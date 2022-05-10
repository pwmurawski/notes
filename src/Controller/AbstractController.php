<?php
declare(strict_types=1);

namespace App\Controller;

require_once('src\View.php');
require_once('src\Model\NoteModel.php');
require_once('src\Exception\ConfigurationException.php');
require_once('src\Exception\StoargeException.php');

use App\View;
use App\Model\NoteModel;
use App\Request;
use App\Exception\ConfigurationException;
use App\Exception\StoargeException;

class AbstractController {
    protected const DEFAULT_ACTION = 'list';
    private static array $configuration = [];
    protected NoteModel $noteModel;
    protected Request $request;
    protected View $view;

    public static function initConfiguration(array $configuration): void {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request) {
        if(empty(self::$configuration['db'])){
            throw new ConfigurationException();
        }
        $this->noteModel = new NoteModel(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void {
        try {
            $methodAction = $this->action() . 'Action';
            if(!method_exists($this, $methodAction)) {
                $methodAction = self::DEFAULT_ACTION . 'Action';
            }

            $this->$methodAction();
        } catch (StoargeException $e) {
            dump($e);
            $this->view->render(
                'error',
                ['message' => $e->getMessage()],
            );
        } catch(NotFoundException $e) {
            $this->redirect('/', ['error' => 'noteNotFound']);
        }
    }

    private function action(): ?string {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

    protected function redirect(string $to, array $params = null): void {
        $location = '';

        if($params) {
            foreach($params as $key => $value) {
                $queryParams[] = urlencode($key) . '=' . urlencode($value);
            }
    
            $queryParams = implode('&', $queryParams);
            $location .= '?' . $queryParams;
        }

        header("Location: $to$location");
        exit;
    }
}