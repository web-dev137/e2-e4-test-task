<?php
namespace App\handlers;

use OpenApi\Annotations as QA;
use OpenApi\Generator;

class Site
{
    public function docs()
    {
        $root = __DIR__."/../";
        $swg = Generator::scan([$root."handlers/api",$root."models"]);

        if($swg->validate()) {
            file_put_contents($root . "docs/swagger.json", $swg->toJson());
            header("Location: http://e2-e4-test-task/app/view/swagger-ui/index.php");
            exit();
        }
        echo $swg->toJson();
    }
}