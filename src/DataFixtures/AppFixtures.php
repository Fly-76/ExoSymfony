<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private function generer_lipsum($quantite = 1, $type = 'paras', $lorem = false) {
            $url = "http://www.lipsum.com/feed/xml?amount=$quantite&what=$type&start=".($lorem?'yes':'no');
            return simplexml_load_file($url)->lipsum;        
    }

    public function load(ObjectManager $manager)
    {
        //$date = new \DateTimeInterface();
        $date = new \DateTime();


        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle('article '  . $i);
            $article->setContent($this->generer_lipsum(300, 'words'));
            $article->setAuthor('Bibi');
            $article->setDate( $date );
            $article->setCategory('catégorie '  . mt_rand(1, 5));
            $article->setViewCount(mt_rand(1, 1000));

            $manager->persist($article);
        }
        $manager->flush();
    }
}
//date('Y-m-d h:i:s')

