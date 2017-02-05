<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/12/16
 * Time: 11:17
 */

namespace taurus\framework\http;


class HttpJsonResponse extends HttpResponse {
    protected function body() {
        echo json_encode($this->body);
    }

    public function getJson() {
        return json_encode($this->body);
    }
}