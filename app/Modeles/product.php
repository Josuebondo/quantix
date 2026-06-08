<?php

namespace App\Modeles;

use Core\Modele;

/**
 * article Modèle
 */
class product extends Modele
{
    protected string $table = 'products';
    protected string $clesPrimaire = 'id';
    /**
     * Relation: un article appartient à une entreprise
     */

    public function company()
    {
        return $this->appartientA('App\Modeles\company', 'company_id');
    }

    /**
     * Relation: un article appartient à une catégorie
     */
    public function category()
    {
        return $this->appartientA('App\Modeles\category', 'category_id');
    }

    /**
     * Relation: un article a plusieurs images
     */
    public function images()
    {
        return $this->aPlusieurs('App\Modeles\product_image', 'product_id', 'id');
    }
}
