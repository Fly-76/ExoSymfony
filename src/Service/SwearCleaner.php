<?php

namespace App\Service;

use App\Entity\Article;

class SwearCleaner
{
    public function cleanSwear(Article $article): Article
    {

        $str     = $article->getContent();
        $order   = array('merde ', 'con ', 'connard ', 'pharetra ');
        $replace = '#### ';

        $newstr = str_ireplace($order, $replace, $str);
        $article->setContent($newstr);

        return $article;
    }
}
