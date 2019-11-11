<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Rpc\Response;
use EasySwoole\Rpc\Rpc;

class Index extends Controller
{

    function index()
    {
        $this->response()->write('hello world');
    }

    function rpc() {
        $client = Rpc::getInstance()->client();
        $client->addCall('user', 'register', ['arg1', 'arg2'])
            ->setOnFail(function (Response $response) {
                $this->response()->write($response);
            })
            ->setOnSuccess(function (Response $response) {
                $this->response()->write($response);
            });

        $client->exec();
    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }


}