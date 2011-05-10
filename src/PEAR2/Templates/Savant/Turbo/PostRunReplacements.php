<?php
namespace PEAR2\Templates\Savant\Turbo;
interface PostRunReplacements
{
    public function setReplacementData($field, $data);
    public function postRun($data);
}
