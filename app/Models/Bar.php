<?php

namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class Bar extends Model
{
    public function GetCategories(): array
    {
        $db = db_connect("member");
        $builder = $db->table("ProductCategories");
        $results = $builder->get();
        // Return the relevant results to the player
        $categories = array();
        foreach ($results->getResultArray() as $category)
        {
            $categories[] = $category["CategoryName"];
        }
        return $categories;
    }

    public function GetProductsFromCategory($category)
    {
        $db = db_connect("member");
        $builder = $db->table("Products");
        $results = $builder->getWhere("ProductCategory = '$category'");
        // Return the relevant results to the player
        $products = array();
        if (!$results) {
            return $products;
        } else {
            return $results->getResultArray();
        }
    }

    public function GetProductFromId($id)
    {
        $db = db_connect("member");
        $builder = $db->table("Products");
        $results = $builder->getWhere("ProductId = '$id'");
        $db->close();
        // Return the relevant results to the player
        $products = array();
        if (!$results) {
            return $products;
        } else {
            return $results->getResultArray()[0];
        }
    }

    public function GetAgeRestrictionOnCategory($category)
    {
        $db = db_connect("member");
        $builder = $db->table("ProductCategories");
        $results = $builder->getWhere("CategoryName = $category");
        // Return the relevant results to the player
        if ($results->getResultArray() == false)
        {
            return false;
        }
        else
        {
            return $results->getResultArray()[0].AgeRestriction;
        }
    }

    public function GetBasketItemsForUser()
    {
        $db = db_connect("member");
        $builder = $db->table("BasketContents");
        $results = $builder->getWhere(['UserId'=>session()->get('userId')]);
        // Return the relevant results to the player
        if ($results->getResultArray() == false)
        {
            return array();
        }
        else
        {
            return $results->getResultArray();
        }
    }

}