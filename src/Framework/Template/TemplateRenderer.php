<?php
/**
 * Created by PhpStorm.
 * User: mashine
 * Date: 16.05.18
 * Time: 14:06
 */

namespace Framework\Template;

interface TemplateRenderer
{
    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;
}
